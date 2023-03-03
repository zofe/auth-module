<?php

use App\Modules\Auth\Components\Admin\UsersTable;
use App\Modules\Auth\Components\Admin\UsersView;
use App\Modules\Auth\Components\Admin\UsersEdit;

use Illuminate\Support\Facades\Route;


Route::get('auth/users', UsersTable::class)
    ->middleware(['web'])
    ->name('auth.users')
    ->crumbs(fn ($crumbs) => $crumbs->push('Users', route('auth.users')));

Route::get('auth/users/view/{user:id}', UsersView::class)
    ->middleware(['web'])
    ->name('auth.users.view')
    ->crumbs(function ($crumbs, $user) {
        $crumbs->parent('auth.users')->push('View User', route('auth.users.view', $user));
    });

Route::get('auth/article/edit/{user:id?}', UsersEdit::class)
    ->middleware(['web'])
    ->name('auth.users.edit')
    ->crumbs(function ($crumbs, $user = null) {
        if ($user) {
            $crumbs->parent('auth.users.view', $user)
                ->push('Edit User', route('auth.users.edit', $user));
        } else {
            $crumbs->parent('auth.users')
                ->push('Add User', route('auth.users.edit'));
        }
    });

