<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Dto\TaskDto;
use App\Models\Task;

interface TaskServiceInterface
{
    public function create(TaskDto $taskDto): bool;
    
    public function getAll(): array;

    public function format(Task $task): array;

    public function remove(Task $task): bool;

    public function update(Task $task, TaskDto $taskDto): bool;
}