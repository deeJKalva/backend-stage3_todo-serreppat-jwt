<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/todos', 'App\Http\Controllers\TodoController@getTodoList');
// Route::post('/todos', 'App\Http\Controllers\TodoController@addTodo');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['prefix' => 'auth'], function() {
//     Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
//     Route::group(['middleware' => 'auth:api'], function() {
//         Route::get('todos', [App\Http\Controllers\TodoController::class, 'getTodoList']);
//         Route::post('todos', [App\Http\Controllers\TodoController::class, 'addTodo']);
//         Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
//         Route::get('me', [App\Http\Controllers\AuthController::class, 'me']);
//         Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
//     });
// });

Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('user', [App\Http\Controllers\AuthController::class, 'me']);
    Route::get('todos', [App\Http\Controllers\TodoController::class, 'getTodoList']);
    Route::post('todos', [App\Http\Controllers\TodoController::class, 'addTodo']);
    Route::get('todos/{id}', [App\Http\Controllers\TodoController::class, 'showTodo']);
    Route::patch('todos/{id}', [App\Http\Controllers\TodoController::class, 'update']);
    Route::delete('todos/{id}', [App\Http\Controllers\TodoController::class, 'destroy']);
});