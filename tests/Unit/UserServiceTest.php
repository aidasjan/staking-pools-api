<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUserByAddress()
    {
        $user = User::factory()->create(['address' => '0x123abc']);
        $userService = new UserService();
        $resultUser = $userService->getUserByAddress('0x123abc');
        $this->assertEquals($user->id, $resultUser->id);
        $this->assertEquals($user->address, $resultUser->address);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create(['address' => '0x123abc']);
        $userService = new UserService();
        $updatedUser = $userService->updateUser($user, (object)['name' => 'John Doe', 'email' => 'john@example.com']);
        $this->assertEquals('John Doe', $updatedUser->name);
        $this->assertEquals('john@example.com', $updatedUser->email);
    }

    public function testCreateUser()
    {
        $userService = new UserService();
        $user = $userService->createUser('0x456def', 'challenge123');
        $this->assertDatabaseHas('users', ['address' => '0x456def', 'challenge' => 'challenge123']);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testSetUserChallenge()
    {
        $user = User::factory()->create(['address' => '0x123abc']);
        $userService = new UserService();
        $userService->setUserChallenge($user, 'new_challenge');
        $user->refresh();
        $this->assertEquals('new_challenge', $user->challenge);
    }
}