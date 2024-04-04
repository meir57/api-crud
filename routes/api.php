<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(static function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::resource('tasks', TaskController::class);
});