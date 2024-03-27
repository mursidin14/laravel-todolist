<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $user = [
        'mursidin' => '123456'
    ];

    function login(string $username, string $password): bool
    {
        if(!isset($this->user[$username])) {
            return false;
        }

        $correctPassword = $this->user[$username];
        return $password == $correctPassword;
    }
}
