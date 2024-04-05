<?php

namespace Database\Factories;

use App\Enums\Status\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(5),
            'status' => $this->faker->randomElement(StatusEnum::values()),
            'user_id' => auth()->user()?->getAuthIdentifier(),
        ];
    }
}
