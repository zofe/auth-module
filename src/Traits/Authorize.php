<?php

namespace Zofe\Auth\Traits;


use App\Models\User;
use Spatie\Permission\Exceptions\UnauthorizedException;
use function Termwind\render;

trait Authorize {

    public static $classInstance = [];


    public function authorize($roleOrPermission, $entity = null)
    {
        /** @var User $user */
        $user = auth()->user();
        if (! $user ) {
            return redirect()->to(route('login'));
            // throw UnauthorizedException::notLoggedIn();
        }

        if(!app()->environment('testing')) {
            $class = get_called_class().json_encode($entity);
            if(isset(self::$classInstance[$user->id.'|'.$class])) {
                return ;
            }
            self::$classInstance[$user->id.'|'.$class] = 1;
        }


        //check rule or pemission
        $rolesOrPermissions = is_array($roleOrPermission)
            ? $roleOrPermission
            : explode('|', $roleOrPermission);

        if (! $user->hasAnyRole($rolesOrPermissions) && ! $user->hasAnyPermission($rolesOrPermissions)) {
            throw UnauthorizedException::forRolesOrPermissions($rolesOrPermissions);
        }

        //todo $entity check

    }
}
