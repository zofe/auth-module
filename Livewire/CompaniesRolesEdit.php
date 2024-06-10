<?php

namespace App\Modules\Auth\Livewire;



use App\Models\User;
use App\Modules\Auth\Models\CompanyRoles;
use App\Modules\Auth\Models\Permission;
use App\Modules\Auth\Models\Role;
use App\Modules\Log\Services\ActivityLogService;
use Livewire\Component;
use App\Modules\Auth\Traits\Authorize;


class CompaniesRolesEdit extends Component
{
    use Authorize;
    public $role;

    public $roles = [];
    public $permissions = [];

    public $perm = [];

    public $readonly = false;
    public $name;

    public $available_permissions = [];
    public $grouped_permissions = [];

    protected $rules = [
        'permissions' => 'nullable',
        'name' => 'nullable',
    ];

    public function booted()
    {
        $this->authorize('admin');
    }

    public function addRule($field, $rule)
    {
        $this->rules[$field] = $rule;
    }

    public function mount(?CompanyRoles $role)
    {
        $this->role = $role;

        if($role->exists) {
            $this->permissions = $this->role->permissions;
            $this->name = $role->name;
        }

        $this->available_permissions = config('company_role_permissions.admin');
        $this->grouped_permissions = config('company_role_permissions.groups');
        foreach ($this->grouped_permissions as $group=>$permissions) {
            foreach ($permissions as $key => $perm) {
                        if (in_array($perm, $this->permissions)) {
                            $this->perm[$group][$key] = true;
                        }
            }
        }
    }

    public function save()
    {
        if(!$this->role->exists && in_array($this->name, array_keys(config('company_role_permissions'))))
        {
            $this->addError('name', __('users::user.role_already_exists'));
            return false;
        }

        $this->validate();
        if(!$this->role->exists) {
            $this->role->company_id = auth()->user()->company_id;
        }
        if($this->name) {
            $this->role->name = $this->name;
        }

        $newp = [];
        foreach ($this->grouped_permissions as $group=>$permissions) {
            if(isset($this->perm[$group])) {
                $newPermissions[$group] = array_filter($this->perm[$group], function ($perm) {
                    return $perm == true;
                });
                $newp = array_merge($newp, array_values(array_intersect_key($this->grouped_permissions[$group], $newPermissions[$group])));
            }
        }

        foreach($newp as $p){
            if(in_array($p, array_keys(config('company_role_permissions.triggers')))){
                $triggerToAdd = config("company_role_permissions.triggers.".$p);
                if(!in_array($triggerToAdd, $newp)){
                    $newp = array_merge($newp, [$triggerToAdd]);
                }
            }
        }

        $validPermissions = array_filter($newp, function ($perm) {
            return strpos($perm,'can ')===0;
        });

        $this->role->permissions = $validPermissions;
        $this->role->save();

        $users = $this->role->users()->get();

        /** @var User $user */
        foreach($users as $user) {
            //ActivityLogService::storeUserActivityLog('edit_user_roles', $user, [], $user->getPermissionNames()->toArray(), $validPermissions);
            $user->syncPermissions($validPermissions);
        }

        return redirect()->to(route_lang('roles.list'));
    }

    public function render()
    {
        return view('auth::company_roles_edit')
            ->layout('auth::admin');
    }
}
