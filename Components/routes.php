<?php

use App\Modules\Auth\Components\Admin\PermissionsEdit;
use App\Modules\Auth\Components\Admin\PermissionsTable;
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

Route::get('auth/users/edit/{user:id?}', UsersEdit::class)
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

Route::get('auth/permissions', PermissionsTable::class)
    ->middleware(['web'])
    ->name('auth.permissions')
    ->crumbs(fn ($crumbs) => $crumbs->push('Permissions', route('auth.permissions')));

Route::get('auth/permissions/edit/{role:id}', PermissionsEdit::class)
    ->middleware(['web'])
    ->name('auth.permissions.edit')
    ->crumbs(function ($crumbs, $role) {
        $crumbs->parent('auth.permissions')
            ->push('Edit User', route('auth.permissions.edit', $role));
    });
