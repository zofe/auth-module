<?php

namespace App\Modules\Auth\Database\Seeders;

use App\Modules\Auth\Models\Permission;
use App\Modules\Auth\Models\Role;
use Illuminate\Database\Seeder;


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


    }
}
