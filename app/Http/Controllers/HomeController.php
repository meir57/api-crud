<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\TaskServiceInterface;

class HomeController extends Controller
{
    public function __construct(
        private readonly TaskServiceInterface $taskService,
    ) {
    }

    public function index() {
        return view('home', ['tasks' => $this->taskService->getAssociatedTasks()]);
    }
}
