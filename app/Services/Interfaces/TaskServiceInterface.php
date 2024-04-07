<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Dto\Task\TaskDto;
use App\Models\Task;

interface TaskServiceInterface
{
    public function create(TaskDto $taskDto): bool;
    
    public function getAssociatedTasks(): ?array;

    public function update(Task $task, TaskDto $taskDto): bool;

    public function remove(Task $task): bool;

    public function format(Task $task): array;
}