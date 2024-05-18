<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Auth\Events\Login;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete("delete from users");

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        self::assertTrue($this->userService->login('mursidinrm14@gmail.com', '123456'));
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
