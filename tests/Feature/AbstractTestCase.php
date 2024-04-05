<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

abstract class AbstractTestCase extends TestCase
{
    private Authenticatable $user;

    protected function login(): void
    {
        if (isset($this->user)) {
            return;
        }

        $this->user = Sanctum::actingAs(User::factory()->create());
    }

    protected function makeTask(bool $save = false): array
    {
        if (!isset($this->user)) {
            return [];
        }
        
        if ($save) {
            return Task::factory()->create()->toArray();
        }

        return Task::factory()->raw();
    }
}
