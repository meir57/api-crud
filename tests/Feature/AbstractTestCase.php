<?php

namespace Tests\Feature;

use App\Enums\Status\StatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

abstract class AbstractTestCase extends TestCase
{
    use WithFaker;

    protected function login(): void
    {
        Sanctum::actingAs(User::factory()->create());
    }

    protected function makeTask(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(5),
            'status' => $this->faker->randomElement(StatusEnum::values()),
        ];
    }
}
