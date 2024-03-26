<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\UserService;
use Illuminate\Auth\Events\Login;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login('mursidin', '123456'));
    }

    public function testLoginNotFoung()
    {
        self::assertFalse($this->userService->login('salah', 'salah'));
    }

    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login('mursidin', 'salah'));
    }
}
