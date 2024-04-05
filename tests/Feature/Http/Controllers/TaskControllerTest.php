<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    private const API_ROUTE = '/api/tasks/';

    public function test_tasks_index_unauthorized(): void
    {
        // Act
        $response = $this->get(self::API_ROUTE);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_tasks_index_authorized(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->get(self::API_ROUTE);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_tasks_store_unauthorized(): void
    {
        // Arrange
        $task = [
            'name' => 'Test task',
            'description' => 'Test description'
        ];

        // Act
        $response = $this->post(self::API_ROUTE, $task);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_tasks_store_authorized(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $task = [
            'name' => 'Test task',
            'description' => 'Test description'
        ];

        // Act
        $response = $this->post(self::API_ROUTE, $task);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas((new Task())->getTable(), $task);
    }

    public function test_tasks_show_nonexistant_task(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $taskId = -1;

        // Act
        $response = $this->get(self::API_ROUTE . $taskId);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    // to be continued
}
