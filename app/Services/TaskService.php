<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\TaskDto;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;

class TaskService implements TaskServiceInterface
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ){
    }
    
    public function create(TaskDto $taskDto): bool
    {
        return $this->taskRepository->insert($taskDto);
    }

    public function getAll(): array
    {
        return $this->taskRepository->select([
            'name',
            'description',
            'status'
        ]
        )->toArray();
    }

    public function format(Task $task): array
    {
        return [
            __('name') => $task->getName(),
            __('description') => $task->getDescription(),
            __('status') => $task->getStatus(),
        ];
    }

    public function remove(Task $task): bool
    {
        return $this->taskRepository->delete($task->getId());
    }

    public function update(Task $task, TaskDto $taskDto): bool
    {
        return $this->taskRepository->update($task->getId(), $taskDto->toArray());
    }
}