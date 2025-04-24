<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\LogController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');

    // Advertisement Management
    Route::resource('ads', AdvertisementController::class);
    Route::post('ads/{advertisement}/approve', [AdvertisementController::class, 'approve'])->name('ads.approve');
    Route::post('ads/{advertisement}/reject', [AdvertisementController::class, 'reject'])->name('ads.reject');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/users', [AnalyticsController::class, 'users'])->name('analytics.users');
    Route::get('/analytics/ads', [AnalyticsController::class, 'ads'])->name('analytics.ads');

    // System Logs
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
    Route::get('/logs/clear', [LogController::class, 'clear'])->name('logs.clear');

    // Settings
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');

    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
}); 