<?php

namespace App\Services;

use Illuminate\Support\Str;

class WalletAuthService
{
    private $userService;
    private $messageAuthenticationService;

    public function __construct(UserService $userService, MessageAuthenticationService $messageAuthenticationService)
    {
        $this->userService = $userService;
        $this->messageAuthenticationService = $messageAuthenticationService;
    }

    /**
     * Get a challenge for wallet authentication.
     *
     * @param string $address
     * @return string
     */
    public function getChallenge($address)
    {
        $challenge = $this->generateChallenge();
        $user = $this->userService->getUserByAddress($address);
        if ($user === null) {
            $user = $this->userService->createUser($address, $challenge);
        } else {
            $this->userService->setUserChallenge($user, $challenge);
        }
        return $challenge;
    }

    /**
     * Authenticate the user based on the provided wallet address and signature.
     *
     * @param string $address
     * @param string $signature
     * @return array|null
     */
    public function login($address, $signature)
    {
        $user = $this->userService->getUserByAddress($address);
        if ($user === null) {
            return null;
        }
        $isValid = $this->messageAuthenticationService->authenticateMessage($user->challenge, $signature, $user->address);
        if (!$isValid) {
            return null;
        }
        $token = $user->createToken('auth');
        return ['name' => $user->name, 'address' => $user->address, 'email' => $user->email, 'token' => $token->plainTextToken];
    }

    /**
     * Generate a challenge for wallet authentication.
     *
     * @return string
     */
    private function generateChallenge()
    {
        return "Please sign this message " . Str::random(10);
    }
}
