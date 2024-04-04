<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Dto\TaskDto;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function insert(TaskDto $taskDto): bool;

    public function select(array $columns = null): Collection;

    public function delete(int $taskId): bool;

    public function update(int $taskId, array $task): bool;
}