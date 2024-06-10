<?php

namespace App\Modules\Auth\Database\Seeders;

use App\Models\User;
use App\Modules\Auth\Models\Permission;
use App\Modules\Auth\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (config('auth.permissions') as $permission) {
            Permission::firstOrNew(['name' => $permission])->save();
        }

        foreach( config('auth.roles') as $role)
        {
            //roles
            $adminRole = Role::firstOrNew(['name' => $role]);
            $adminRole->save();
            $adminRole->givePermissionTo(config('auth.role_permissions.'.$role));
        }



        $user = User::factory()->create([
            'email' => 'admin@laravel',
            'password' => Hash::make('admin'),
        ]);

        //role assign
        $user->assignRole('admin');
        $user->save();

    }
}
