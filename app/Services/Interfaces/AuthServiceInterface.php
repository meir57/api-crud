<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Dto\UserDto;

interface AuthServiceInterface
{
    public function login(UserDto $userCredentials): ?string;
}