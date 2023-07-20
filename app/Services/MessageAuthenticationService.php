<?php

namespace App\Services;

use Pelieth\LaravelEcrecover\EthSigRecover;

class MessageAuthenticationService
{
    public function authenticateMessage($message, $signature, $address)
    {
        $ethSigUtil = new EthSigRecover();
        $addressFromSignature = $ethSigUtil->personal_ecRecover($message, $signature);
        return strtolower($addressFromSignature) === strtolower($address);
    }
}
