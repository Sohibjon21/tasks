<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\TaskController;
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

Route::get('expired', function () {
    return response("You don't have access", 403);
})->name('expired');

Route::controller(ApiController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::prefix('tasks')->group(function () {

        Route::get('/', [TaskController::class, 'index']);
        Route::get('/show/{task}', [TaskController::class, 'show']);
        Route::post('/', [TaskController::class, 'store']);
        Route::put('/update/{task}', [TaskController::class, 'update']);
        Route::delete('/delete/{task}', [TaskController::class, 'destroy']);
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
