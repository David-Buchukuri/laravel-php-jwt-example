<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SwaggerController;

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


Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.auth')->name('me');

Route::delete('/items', [ItemController::class, 'delete'])->middleware('jwt.auth')->name('items.delete');

// vulnerable if cookie is set to lax and user is redirected from attacker's website to this route
Route::get('/delete-items', [ItemController::class, 'delete'])->middleware('jwt.auth');

Route::get('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth')->name('logout');

Route::post('/swagger-login', [SwaggerController::class, 'login'])->name('swagger_login');
