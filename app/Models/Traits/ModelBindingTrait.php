<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ModelBindingTrait
{
    public function resolveRouteBinding(mixed $value, mixed $fields = null): mixed
    {
        if (!ctype_digit($value)) {
            throw (new ModelNotFoundException())->setModel(self::class);
        }

        return parent::resolveRouteBinding($value);
    }
}
