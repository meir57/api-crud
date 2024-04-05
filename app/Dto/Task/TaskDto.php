<?php

declare(strict_types=1);

namespace App\Dto\Task;

use App\Enums\Status\StatusEnum;

class TaskDto
{
    public function __construct(
        private string $name,
        private string $description,
        private StatusEnum $status = StatusEnum::UNFINISHED,
        private int $userId,
    ){
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status->value;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'status' => $this->getStatus(),
            'user_id' => $this->getUserId(),
        ];
    }
}