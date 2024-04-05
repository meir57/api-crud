<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function login(): void
    {
        Sanctum::actingAs(User::factory()->create());
    }

    protected function makeTask(bool $save = false): array
    {
        if ($save) {
            return Task::factory()->create()->toArray();
        }

        return Task::factory()->raw();
    }
}
