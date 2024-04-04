<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
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
Route::group([

    'middleware' => 'auth:sanctum',
    'prefix' => 'auth'

], function ($router) {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
});
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group([

    'middleware' => 'auth:sanctum',
    'prefix' => 'status'

], function ($router) {

    Route::get('', [StatusController::class, 'index']);
    Route::post('store', [StatusController::class, 'store']);
    Route::get('{item}', [StatusController::class, 'view']);
    Route::post('{item}', [StatusController::class, 'update']);
    Route::delete('{item}', [StatusController::class, 'delete']);
});

Route::group([

    'middleware' => 'auth:sanctum',
    'prefix' => 'tasks'

], function ($router) {

    Route::get('', [TaskController::class, 'index']);
    Route::post('store', [TaskController::class, 'store']);
    Route::get('{item}', [TaskController::class, 'view']);
    Route::post('{item}', [TaskController::class, 'update']);
    Route::delete('{item}', [TaskController::class, 'delete']);
});
