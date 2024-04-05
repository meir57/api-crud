<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function insert(array $task): bool
    {
        return Task::create($task)->save();
    }

    public function delete(int $taskId): bool
    {
        return (bool) Task::find($taskId)->delete();
    }

    public function update(int $taskId, array $task): bool
    {
        return Task::find($taskId)->update($task);
    }
}