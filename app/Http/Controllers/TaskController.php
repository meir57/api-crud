<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Responses\CreatedResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Task;
use App\Services\Interfaces\TaskServiceInterface;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskServiceInterface $taskService,
    ){
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): SuccessResponse
    {
        return new SuccessResponse(
            $this->taskService->getAll(),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): CreatedResponse|ErrorResponse
    {
        $response = $this->taskService->create($request->getDto());

        if ($response) {
            return new CreatedResponse();
        }

        return new ErrorResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): SuccessResponse
    {
        return new SuccessResponse(
            $this->taskService->format($task),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): SuccessResponse|ErrorResponse
    {
        $response = $this->taskService->update($task, $request->getDto());

        if ($response) {
            return new SuccessResponse();
        }

        return new ErrorResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): SuccessResponse|ErrorResponse
    {
        $response = $this->taskService->remove($task);

        if ($response) {
            return new SuccessResponse();
        }

        return new ErrorResponse();
    }
}
