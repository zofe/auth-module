<?php

namespace App\Modules\Auth\Components\Admin;



use App\Models\User;
use Livewire\Component;
use Zofe\Auth\Traits\Authorize;


class UsersView extends Component
{
    use Authorize;
    public $user;

    public function booted()
    {
        $this->authorize('admin|edit users');
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('auth::Admin.views.users_view')->layout('auth::admin');
    }
}
