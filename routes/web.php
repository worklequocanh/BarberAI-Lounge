<?php

use App\Http\Controllers\Admin\AiAssistantController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\BarberController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailCampaignController;
use App\Http\Controllers\Admin\HairstyleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Appointments
    Route::get('appointments/timeline', [AppointmentController::class, 'timeline'])->name('appointments.timeline');
    Route::resource('appointments', AppointmentController::class);

    // Barbers
    Route::post('barbers/{barber}/leaves', [BarberController::class, 'storeLeave'])->name('barbers.leaves.store');
    Route::delete('barbers/{barber}/leaves/{leave}', [BarberController::class, 'destroyLeave'])->name('barbers.leaves.destroy');
    Route::resource('barbers', BarberController::class);

    // Services
    Route::resource('services', ServiceController::class);

    // Hairstyles
    Route::resource('hairstyles', HairstyleController::class);

    // AI Assistant
    Route::get('ai', [AiAssistantController::class, 'index'])->name('ai.index');

    // Email Marketing Campaigns
    Route::post('campaigns/{campaign}/send', [EmailCampaignController::class, 'send'])->name('campaigns.send');
    Route::resource('campaigns', EmailCampaignController::class);

    // Coupons
    Route::resource('coupons', CouponController::class);

    // Users
    Route::resource('users', UserController::class);
});
