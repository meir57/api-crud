<?php

declare(strict_types=1);

namespace App\Enums\Traits;

use App\Enums\EnumInterface;

trait EnumTrait
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function isContain(string|int $value): bool
    {
        return in_array($value, self::values(), true);
    }

    public function isNot(EnumInterface $enum): bool
    {
        return false === $this->is($enum);
    }

    public function is(EnumInterface $enum): bool
    {
        return $enum === $this;
    }

    public function in(array $values): bool
    {
        return in_array($this, $values, true);
    }
}