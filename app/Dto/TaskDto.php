<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enums\Status\StatusEnum;

class TaskDto
{
    public function __construct(
        private string $name,
        private string $description,
        private StatusEnum $status = StatusEnum::UNFINISHED,
    ){
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status->value,
        ];
    }
}