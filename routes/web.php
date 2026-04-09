<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

// Public
Route::get('/', [PublicController::class, 'landing'])->name('public.landing');
Route::match(['get', 'post'], '/track', [PublicController::class, 'track'])->name('public.track');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin (protected by auth middleware)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::post('/tracking/search', [TrackingController::class, 'search'])->name('tracking.search');
    Route::get('/tracking/{order}', [TrackingController::class, 'show'])->name('tracking.show');

    Route::get('/senders', [SenderController::class, 'index'])->name('senders.index');
    Route::get('/receivers', [ReceiverController::class, 'index'])->name('receivers.index');

    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::put('/billing/{order}', [BillingController::class, 'update'])->name('billing.update');

    Route::get('/courier', [CourierController::class, 'index'])->name('courier.index');
    Route::post('/courier/{order}/log', [CourierController::class, 'updateLog'])->name('courier.updateLog');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// API - Cascading Location Dropdowns
Route::get('/api/locations/cities/{province}', [LocationController::class, 'cities']);
Route::get('/api/locations/districts/{city}', [LocationController::class, 'districts']);
Route::get('/api/locations/villages/{district}', [LocationController::class, 'villages']);
