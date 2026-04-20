<?php

use App\Http\Controllers\Api\Auth\{LoginController, RegistrationController};
use App\Http\Controllers\Api\ProjectController;
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

Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login');
});

Route::controller(RegistrationController::class)->group(function () {
    Route::post('/register', 'register');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::post('/logout', 'logout');
    });

    Route::controller(ProjectController::class)->prefix('project')->group(function () {
        Route::get('list', 'list');
        Route::post('store', 'store');
        Route::get('edit/{id}', 'edit');
        Route::post('update', 'update');
        Route::get('destroy/{id}', 'destroy');
    });
});
