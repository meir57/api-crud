<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\UserDto;
use App\Enums\Token\TokenTypeEnum;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ){
    }

    public function login(UserDto $userCredentials): ?string
    {
        if (Auth::guard('web')->attempt($userCredentials->toArray())) {
            $user = $this->userRepository->requireByEmail($userCredentials->getEmail());
            if ($user) {
                $token = $user->createToken(TokenTypeEnum::AUTH_TOKEN->value)->plainTextToken;
                return $token;
            }
        }

        return null;
    }
}