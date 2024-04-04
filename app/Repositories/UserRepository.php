<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function requireByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}