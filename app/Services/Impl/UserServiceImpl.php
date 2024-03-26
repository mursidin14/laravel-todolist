<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $user = [
        'mursidin' => '123456'
    ];

    function login(string $usernmae, string $password): bool
    {
        if(!isset($this->user[$usernmae])) {
            return false;
        }

        $correctPassword = $this->user[$usernmae];
        return $password == $correctPassword;
    }
}
