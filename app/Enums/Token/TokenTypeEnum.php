<?php

declare(strict_types=1);

namespace App\Enums\Token;
use App\Enums\Traits\EnumTrait;

enum TokenTypeEnum: string
{
    use EnumTrait;
    
    case AUTH_TOKEN = 'auth-token';

    /*
        we can add more token types if necessary
        (i.e registration, forgot / reset password, etc.)
    */
}