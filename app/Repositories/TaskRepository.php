<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\TaskDto;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function insert(TaskDto $taskDto): bool
    {
        return Task::create($taskDto->toArray())->save();
    }

    public function select(array $columns = null): Collection
    {
        return Task::select($columns)->get();
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