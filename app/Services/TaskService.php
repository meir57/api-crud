<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Task\TaskDto;
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
        return $this->taskRepository->insert($taskDto->toArray());   
    }

    public function getAssociatedTasks(): ?array
    {
        return auth()->user()?->tasks->map(fn(Task $task) => $this->format($task))->toArray();
    }

    public function update(Task $task, TaskDto $taskDto): bool
    {
        return $this->taskRepository->update($task->getId(), $taskDto->toArray());
    }

    public function remove(Task $task): bool
    {
        return $this->taskRepository->delete($task->getId());
    }

    public function format(Task $task): array
    {
        return [
            __('id') => $task->getId(),
            __('name') => $task->getName(),
            __('description') => $task->getDescription(),
            __('status') => $task->getStatus(),
        ];
    }
}