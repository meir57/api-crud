<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Token\TokenDto;
use App\Dto\User\UserDto;
use App\Enums\Token\TokenTypeEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ){
    }

    public function login(UserDto $userCredentials): ?TokenDto
    {
        if (auth('web')->attempt($userCredentials->toArray())) {
            $user = $this->userRepository->requireByEmail($userCredentials->getEmail());
            if ($user) {
                $tokenType = TokenTypeEnum::BEARER_TOKEN;
                $expiresAt = now()->addDay();
                $token = $user->createToken($tokenType->value, expiresAt: $expiresAt)->plainTextToken;

                return new TokenDto($tokenType, $token, $expiresAt->diffForHumans(parts: 2));
            }
        }

        return null;
    }

    public function logout(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }

    public function format(User $user): array
    {
        return [
            __('id') => $user->id,
            __('name') => $user->name,
            __('email') => $user->email,
        ];
    }
}
