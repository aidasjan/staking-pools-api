<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Get a user by their Ethereum address.
     *
     * @param string $address
     * @return User|null
     */
    public function getUserByAddress($address)
    {
        return User::where('address', $address)->first();
    }

    /**
     * Update user data based on the provided information.
     *
     * @param User $user
     * @param object $data
     * @return User
     */
    public function updateUser($user, $data)
    {
        $user->name = $data->name;
        $user->email = $data->email;
        $user->save();
        return $user;
    }

    /**
     * Create a new user with the provided Ethereum address and challenge.
     *
     * @param string $address
     * @param string $challenge
     * @return User
     */
    public function createUser($address, $challenge)
    {
        $user = new User();
        $user->address = $address;
        $user->challenge = $challenge;
        $user->save();
        return $user;
    }

    /**
     * Set the challenge for the specified user.
     *
     * @param User $user
     * @param string $challenge
     * @return void
     */
    public function setUserChallenge($user, $challenge)
    {
        $user->challenge = $challenge;
        $user->save();
    }
}
