<?php

namespace App\Modules\Auth\Components\Admin;



use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class UsersEdit extends Component
{

    public $user;

    public $psswd;

    public $roles = [];

    public $unchangable = [1, 2, 3, 4, 5, 6, 7];

    public $fixed_type;

    public $readonly = false;


    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required|email|unique:users,email',
        'psswd' => 'nullable',
    ];

    public function addRule($field, $rule)
    {
        $this->rules[$field] = $rule;
    }

    public function mount(?User $user)
    {
        $this->user = $user;
    }

    public function save()
    {
        if(!$this->user->exists)
        {
            $this->addRule('psswd', 'required|min:8');
        } else {
            $this->addRule('user.email', 'required|email|unique:users,email,'.$this->user->id);
        }

        $this->validate();

        if($this->psswd)
        {
            $this->user->password = Hash::make($this->psswd);
        }

        $this->user->save();

        return redirect()->to(route('auth.users.view', $this->user->getKey()));
    }

    public function render()
    {
        return view('auth::Admin.views.users_edit')
            ->layout('demo::admin');
    }
}
