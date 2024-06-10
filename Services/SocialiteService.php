<?php

namespace App\Modules\Auth\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialiteService {
    public static function loginOrRegister($driver, $payload){
        $existingUser = User::where('email', $payload->email)->first();

        if(!$payload->email){
            return redirect('/login');
        }

        $existingTrashedUser = User::where('email', $payload->email)->whereNotNull('deleted_at')->withTrashed()->first();
        if($existingTrashedUser){
            if(optional(optional($existingTrashedUser->company)->owner)->id != $existingTrashedUser->id){
                $existingTrashedUser->forceDelete();
            }
        }

        if($existingUser){
            auth()->login($existingUser, true);
        } else {
            $newCompany = new Company();
            $newCompany->firstname = $payload->name;
            $newCompany->lastname = 'Customer';
            $newCompany->email = $payload->email;
            $newCompany->password = Hash::make(Str::password(16));
            $newCompany->business_name = $payload->name . " company";
            $newCompany->is_active = true;

            $newCompany->save();

            if($driver == 'google'){
                $newCompany->owner->google_id = $payload->id;
            }elseif($driver == 'github'){
                $newCompany->owner->github_id = $payload->id;
            }elseif($driver == 'discord'){
                $newCompany->owner->discord_id = $payload->id;
            }

            $newCompany->owner->avatar = $payload->avatar;
            $newCompany->owner->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $newCompany->owner->save();

            $newCompany->assignRole('msp');
            $newCompany->owner->assignRole('msp');
            $newCompany->owner->assignRole('user');
            $newCompany->owner->save();

            PermissionService::makeCompanyPermissionsPreset($newCompany);
            $role_id = CompanyRoles::where('name','=','admin')->where('company_id','=',$newCompany->id)->first()->id;
            $newCompany->owner->company_role_id = $role_id;
            $newCompany->owner->givePermissionTo(config('company_role_permissions.admin'));
            $newCompany->owner->save();
            auth()->login($newCompany->owner, true);
        }
        return redirect()->to('/');
    }
}
