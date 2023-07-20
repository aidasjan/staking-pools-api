<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUserByAddress($address)
    {
        return User::where('address', $address)->first();
    }

    public function createUser($address, $challenge)
    {
        $user = new User();
        $user->address = $address;
        $user->challenge = $challenge;
        $user->save();
        return $user;
    }

    public function setUserChallenge($user, $challenge)
    {
        $user->challenge = $challenge;
        $user->save();
    }
}
