<?php

namespace Tests\Unit;

use App\Services\MessageAuthenticationService;
use Pelieth\LaravelEcrecover\EthSigRecover;
use PHPUnit\Framework\TestCase;

class MessageAuthenticationServiceTest extends TestCase
{
    public function testAuthenticateMessageWithValidSignature()
    {
        $message = 'Please sign this message SHxjbknccp';
        $address = '0x49cc9EDC3cfB2456987CABd89703bBB26B560864';
        $signature = '0x62274308a8f65905f31874930a3dcb4bcf2f44b47153f11945dd9789fe6a6e6220a39c0c267ce651d7d81e37affbe97e3a698b0c5630eeadec0c244e69c612111b';

        $messageAuthService = new MessageAuthenticationService();

        $result = $messageAuthService->authenticateMessage($message, $signature, $address);

        $this->assertTrue($result);
    }

    public function testAuthenticateMessageWithInvalidSignature()
    {
        $message = 'Please sign this message SHxjbknccp';
        $address = '0x49cc9EDC3cfB2456987CABd89703bBB26B560864';
        $signature = '0x72274308a8f65905f31874930a3dcb4bcf2f44b47153f11945dd9789fe6a6e6220a39c0c267ce651d7d81e37affbe97e3a698b0c5630eeadec0c244e69c612111c';

        $messageAuthService = new MessageAuthenticationService();

        $result = $messageAuthService->authenticateMessage($message, $signature, $address);

        $this->assertFalse($result);
    }
}
