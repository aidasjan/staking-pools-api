<?php

namespace App\Services;

use Pelieth\LaravelEcrecover\EthSigRecover;

class MessageAuthenticationService
{
    private $ethSigRecover;

    public function __construct()
    {
        $this->ethSigRecover = new EthSigRecover();
    }

    /**
     * Authenticate a signed message.
     *
     * @param string $message
     * @param string $signature
     * @param string $address
     * @return bool
     */
    public function authenticateMessage($message, $signature, $address)
    {
        $addressFromSignature = $this->ethSigRecover->personal_ecRecover($message, $signature);
        return strtolower($addressFromSignature) === strtolower($address);
    }
}
