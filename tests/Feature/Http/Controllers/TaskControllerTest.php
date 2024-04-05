<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\Status\StatusEnum;
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
            'name' => 'Test task 1',
            'description' => 'Test description 1'
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
            'name' => 'Test task 2',
            'description' => 'Test description 2'
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

    public function test_tasks_show_existant_task(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $task = [
            'name' => 'Test task 3',
            'description' => 'Test description 3'
        ];
        $this->post(self::API_ROUTE, $task);
        $createdTask = end($this->get(self::API_ROUTE)->json()['data']);
        $targetTaskId = $createdTask['id'];

        // Act
        $response = $this->get(self::API_ROUTE . $targetTaskId);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_tasks_update_nonexistant_task(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $targetTaskId = -1;
        $task = [
            'name' => 'Test task 4',
            'description' => 'Test description 4',
        ];

        // Act
        $response = $this->put(self::API_ROUTE . $targetTaskId, $task);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_tasks_update_existant_task(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $task = [
            'name' => 'Test task 5',
            'description' => 'Test description 5'
        ];
        $this->post(self::API_ROUTE, $task);
        $createdTask = current($this->get(self::API_ROUTE)->json()['data']);
        $targetTaskId = $createdTask['id'];
        $updatedTask = [
            'name' => 'New test task 1',
            'description' => 'New test description 1',
            'status' => StatusEnum::FINISHED->value,
        ];

        // Act
        $response = $this->put(self::API_ROUTE . $targetTaskId, $updatedTask);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing((new Task())->getTable(), $task);
        $this->assertDatabaseHas((new Task())->getTable(), $updatedTask);
    }

    public function test_tasks_delete_nonexistant_task(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $targetTaskId = -1;

        // Act
        $response = $this->delete(self::API_ROUTE . $targetTaskId);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_tasks_delete_existant_task(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());
        $task = [
            'name' => 'Test task 6',
            'description' => 'Test description 6'
        ];
        $this->post(self::API_ROUTE, $task);
        $createdTask = end($this->get(self::API_ROUTE)->json()['data']);
        $targetTaskId = $createdTask['id'];

        // Act
        $response = $this->delete(self::API_ROUTE . $targetTaskId);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing((new Task())->getTable(), $task);
    }
}
