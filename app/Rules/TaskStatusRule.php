<?php

namespace App\Rules;

use App\Enums\Status\StatusEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TaskStatusRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!empty($value) && !StatusEnum::isContain($value)) {
            $fail(__('Invalid status.'));
        }
    }
}
