<?php

use App\Task\Presentation\Http\Controllers\DeleteTaskController;
use App\Task\Presentation\Http\Controllers\GetTaskStatsController;
use App\Task\Presentation\Http\Controllers\GetTasksController;
use App\Task\Presentation\Http\Controllers\StoreTaskController;
use App\Task\Presentation\Http\Controllers\UpdateTaskController;
use App\Task\Presentation\Http\Middleware\CheckTaskOwnership;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('', GetTasksController::class);
    Route::post('/store', StoreTaskController::class);
    Route::get('/stats', GetTaskStatsController::class);
    
    Route::middleware(CheckTaskOwnership::class)->group(function () {
        Route::put('/{id}/update', UpdateTaskController::class);
        Route::delete('/{id}/delete', DeleteTaskController::class);
    });
}); 