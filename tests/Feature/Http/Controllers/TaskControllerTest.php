<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\AbstractTestCase;

class TaskControllerTest extends AbstractTestCase
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
        $this->login();

        // Act
        $response = $this->get(self::API_ROUTE);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_tasks_store_unauthorized(): void
    {
        // Arrange
        $task = $this->makeTask();

        // Act
        $response = $this->post(self::API_ROUTE, $task);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_tasks_store_authorized(): void
    {
        // Arrange
        $this->login();
        $task = $this->makeTask();

        // Act
        $response = $this->post(self::API_ROUTE, $task);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas((new Task())->getTable(), $task);
    }

    public function test_tasks_show_nonexistent_task(): void
    {
        // Arrange
        $this->login();
        $taskId = -1;

        // Act
        $response = $this->get(self::API_ROUTE . $taskId);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_tasks_show_existent_task(): void
    {
        // Arrange
        $this->login();
        $task = $this->makeTask(save: true);
        $targetTaskId = $task['id'];

        // Act
        $response = $this->get(self::API_ROUTE . $targetTaskId);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'data' => [
                'id' => $task['id'],
                'name' => $task['name'],
                'description' => $task['description'],
                'status' => $task['status'],
            ]
        ]);
    }

    public function test_tasks_update_nonexistent_task(): void
    {
        // Arrange
        $this->login();
        $targetTaskId = -1;
        $task = $this->makeTask();

        // Act
        $response = $this->put(self::API_ROUTE . $targetTaskId, $task);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_tasks_update_existent_task(): void
    {
        // Arrange
        $this->login();
        $task = $this->makeTask(save: true);
        $targetTaskId = $task['id'];
        $updatedTask = $this->makeTask();
        
        // Act
        $response = $this->put(self::API_ROUTE . $targetTaskId, $updatedTask);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing((new Task())->getTable(), $task);
        $this->assertDatabaseHas((new Task())->getTable(), $updatedTask);
    }

    public function test_tasks_delete_nonexistent_task(): void
    {
        // Arrange
        $this->login();
        $targetTaskId = -1;

        // Act
        $response = $this->delete(self::API_ROUTE . $targetTaskId);

        // Assert
        $response->assertJsonFragment(['success' => false]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_tasks_delete_existent_task(): void
    {
        // Arrange
        $this->login();
        $task = $this->makeTask(save: true);
        $targetTaskId = $task['id'];

        // Act
        $response = $this->delete(self::API_ROUTE . $targetTaskId);

        // Assert
        $response->assertJsonFragment(['success' => true]);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing((new Task())->getTable(), $task);
    }
}
