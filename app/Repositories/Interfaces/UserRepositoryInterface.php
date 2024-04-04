<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function requireByEmail(string $email): ?User;
}