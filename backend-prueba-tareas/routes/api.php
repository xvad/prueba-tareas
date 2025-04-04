<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Incluir rutas de autenticación desde la capa de presentación
Route::prefix('auth')->group(function () {
    require app_path('Auth/Presentation/routes.php');
});

Route::prefix('task')->group(function () {
    require app_path('Task/Presentation/routes.php');
});

Route::prefix('user')->group(function () {
    require app_path('User/Presentation/routes.php');
});
