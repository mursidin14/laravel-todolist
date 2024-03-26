<?php

namespace App\Services;

interface UserService 
{
    function login(string $usernmae, string $password): bool;
}
