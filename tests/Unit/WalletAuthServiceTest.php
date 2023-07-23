<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\MessageAuthenticationService;
use App\Services\UserService;
use App\Services\WalletAuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class WalletAuthServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGetChallengeForNewUser()
    {
        $address = '0x123abc';
        $userServiceMock = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userServiceMock->expects($this->once())
            ->method('getUserByAddress')
            ->with($address)
            ->willReturn(null);
        $userServiceMock->expects($this->once())
            ->method('createUser')
            ->with($address, $this->isType('string'))
            ->willReturn(new User());

        $walletAuthService = new WalletAuthService($userServiceMock, new MessageAuthenticationService());

        $challenge = $walletAuthService->getChallenge($address);

        $this->assertIsString($challenge);
    }

    public function testGetChallengeForExistingUser()
    {
        $address = '0x456def';
        $user = User::factory()->create(['address' => $address]);
        $userServiceMock = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userServiceMock->expects($this->once())
            ->method('getUserByAddress')
            ->with($address)
            ->willReturn($user);
        $userServiceMock->expects($this->once())
            ->method('setUserChallenge')
            ->with($user, $this->isType('string'));

        $walletAuthService = new WalletAuthService($userServiceMock, new MessageAuthenticationService());

        $challenge = $walletAuthService->getChallenge($address);

        $this->assertIsString($challenge);
    }

    public function testLoginWithValidSignature()
    {
        $address = '0x789xyz';
        $user = User::factory()->create(['address' => $address, 'challenge' => 'challenge123']);
        $token = Str::random(60);
        $user->createToken('auth', ['*'])->accessToken = $token;
        $signature = 'valid_signature';

        $messageAuthServiceMock = $this->getMockBuilder(MessageAuthenticationService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $messageAuthServiceMock->method('authenticateMessage')
            ->willReturn(true);

        $userServiceMock = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userServiceMock->method('getUserByAddress')
            ->willReturn($user);

        $walletAuthService = new WalletAuthService($userServiceMock, $messageAuthServiceMock);

        $result = $walletAuthService->login($address, $signature);

        $this->assertNotEmpty($result['name']);
        $this->assertNotEmpty($result['address']);
        $this->assertNotEmpty($result['email']);
        $this->assertNotEmpty($result['token']);
    }

    public function testLoginWithInvalidSignature()
    {
        $address = '0x987pqr';
        $signature = 'invalid_signature';
        $messageAuthServiceMock = $this->getMockBuilder(MessageAuthenticationService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $messageAuthServiceMock->expects($this->once())
            ->method('authenticateMessage')
            ->willReturn(false);

        $userServiceMock = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userServiceMock->method('getUserByAddress')
            ->willReturn(new User());

        $walletAuthService = new WalletAuthService($userServiceMock, $messageAuthServiceMock);

        $result = $walletAuthService->login($address, $signature);

        $this->assertNull($result);
    }
}
