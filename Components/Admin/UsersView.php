<?php

namespace App\Modules\Auth\Components\Admin;



use App\Models\User;
use Livewire\Component;


class UsersView extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('auth::Admin.views.users_view')->layout('auth::admin');
    }
}
