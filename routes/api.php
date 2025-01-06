<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckTaskPermission;
use App\Http\Controllers\TaskShareController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//route task
Route::resource('tasks', TaskController::class);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tasks/{taskId}/share', [TaskShareController::class, 'inviteUser']);
    Route::get('/tasks/{taskId}/access-list', [TaskShareController::class, 'showAccessList']);
    Route::delete('/tasks/{taskId}/remove-access', [TaskShareController::class, 'removeAccess']);

    // Endpoint untuk mengakses task berdasarkan izin
    Route::get('/tasks/{taskId}', [TaskController::class, 'show'])
        ->middleware(CheckTaskPermission::class.':view-only');
});