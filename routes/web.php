<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\BarberController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\HairstyleController;
use App\Http\Controllers\Admin\AiAssistantController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Appointments
    Route::resource('appointments', AppointmentController::class);

    // Barbers
    Route::resource('barbers', BarberController::class);

    // Services
    Route::resource('services', ServiceController::class);

    // Hairstyles
    Route::resource('hairstyles', HairstyleController::class);

    // AI Assistant
    Route::get('ai', [AiAssistantController::class, 'index'])->name('ai.index');

    // Coupons
    Route::resource('coupons', CouponController::class);

    // Users
    Route::resource('users', UserController::class);
});
