<?php

declare(strict_types=1);

namespace App\Dto\Token;

use App\Enums\Token\TokenTypeEnum;
use Illuminate\Contracts\Support\Arrayable;

class TokenDto implements Arrayable
{
    public function __construct(
        private TokenTypeEnum $type,
        private string $token,
        private string $expiresIn,
    ){
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'token' => $this->token,
            'expires_in' => $this->expiresIn,
        ];
    }
}