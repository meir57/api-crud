<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface
{
    public function insert(array $task): bool;

    public function delete(int $taskId): bool;

    public function update(int $taskId, array $task): bool;
}