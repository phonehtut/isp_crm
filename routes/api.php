<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

// Route::post('login', [AuthController::class, 'login'])->name('login');
// Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::apiResource('customers', CustomerController::class);
// });
