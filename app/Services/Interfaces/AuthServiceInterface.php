<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Dto\Token\TokenDto;
use App\Dto\User\UserDto;
use App\Models\User;

interface AuthServiceInterface
{
    public function login(UserDto $userCredentials): ?TokenDto;

    public function logout(): void;

    public function format(User $user): array;
}
