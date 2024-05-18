<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::delete("delete from users");
    }

    public function testLoginPage()
    {
        $this->get('/login')->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'username' => 'mursidin'
        ])->get('/login')->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        
        $this->post('/login', [
            'username' => 'mursidinrm14@gmail.com',
            'password' => '123456'
        ])->assertRedirect('/')->assertSessionHas('username', 'mursidinrm14@gmail.com');
    }

    public function testLoginForUser()
    {
        $this->withSession([
            'username' => 'mursidin'
        ])->post('/login', [
            'username' => 'mursidin',
            'password' => '123456'
        ])->assertRedirect('/');
    }


    public function testLoginEmpty()
    {
        $this->post('/login', [])->assertSeeText('username or password is required');
    }

    public function testLoginFiled()
    {
        $this->post('/login', [
            'username' => 'salah',
            'password' => 'salah'
        ])->assertSeeText('username or password invalid');
    }

    public function testLogout()
    {
        $this->withSession([
            'username' => 'mursidin'
        ])->post('/logout')->assertRedirect('/')->assertSessionMissing('username');
    }

    public function testLogoutMiddleware()
    {
        $this->post('/logout')->assertRedirect('/login');
    }
}
