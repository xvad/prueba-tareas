<?php

use App\User\Presentation\Http\Controllers\GetUsersController;
use App\User\Presentation\Http\Controllers\GetUsersForTaskFilterController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/for-task-filter', GetUsersForTaskFilterController::class);

});
