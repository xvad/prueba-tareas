<?php

use Illuminate\Support\Facades\Route;
use App\Auth\Presentation\Http\Controllers\LoginController;
use App\Auth\Presentation\Http\Controllers\RegisterController;
use App\Auth\Presentation\Http\Controllers\LogoutController;
use App\Auth\Presentation\Http\Controllers\MeController;

// Rutas públicas de autenticación
Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

// Rutas protegidas de autenticación
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::get('/me', MeController::class);
}); 