<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\{
    CustomerController,
    ProfileController,
    DashboardController,
    LoginController,
    ProjectController,
    ProjectStatusController,
};

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'checking_login')->name('checking.login');
    Route::get('logout', 'logout')->name('logout');
});
Route::resource('register', CustomerController::class);

Route::middleware(['auth', 'auth.backend'])->group(function () {
    Route::resource('profile', ProfileController::class);
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
    });

    Route::resource('project', ProjectController::class);
    Route::resource('project-status', ProjectStatusController::class);
});
