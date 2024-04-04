<?php

declare(strict_types=1);

namespace App\Enums;

interface EnumInterface
{
    public function is(self $enum): bool;
    public function isNot(EnumInterface $enum): bool;
}