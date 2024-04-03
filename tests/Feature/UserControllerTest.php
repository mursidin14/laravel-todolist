<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
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
        $this->post('/login', [
            'username' => 'mursidin',
            'password' => '123456'
        ])->assertRedirect('/')->assertSessionHas('username', 'mursidin');
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
}
