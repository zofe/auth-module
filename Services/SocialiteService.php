<?php

namespace App\Modules\Auth\Services;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SocialiteService {
    public static function loginOrRegister($driver, $payload){
        $existingUser = User::where('email', $payload->email)->first();

        if(!$payload->email){
            return redirect('/login');
        }

//        $existingTrashedUser = User::where('email', $payload->email)->whereNotNull('deleted_at')->withTrashed()->first();
//        if($existingTrashedUser){
//            $existingTrashedUser->forceDelete();
//        }

        if($existingUser){
            auth()->login($existingUser, true);
        } else {
            $newUser = new User();
            $newUser->name = $payload->name;
            $newUser->email = $payload->email;
            $newUser->password = Hash::make(Str::password(16));
            $newUser->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $newUser->google_id = $payload->id;
            $newUser->avatar = $payload->avatar;
            $newUser->save();

            auth()->login($newUser, true);
        }
        return redirect()->to('/');
    }
}
