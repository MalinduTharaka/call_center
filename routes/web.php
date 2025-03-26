<?php

use App\Http\Controllers\AddAccountController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\OrderConroller;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\WorkTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    //Order Routes
    Route::get('/orders', [OrderConroller::class, 'index']);
    Route::get('/new/orders', [OrderConroller::class, 'index1']);

    //Work Type Routes
    Route::get('/work-types', [WorkTypeController::class, 'index']);

    //Add Account Routes
    Route::get('/add-account', [AddAccountController::class, 'index']);

    //Package Routes
    Route::get('/packages', [PackageController::class, 'index']);
});



Route::post('/verify-device', [DeviceController::class, 'verifyDevice']);
Route::get('/check-device', [DeviceController::class, 'checkDevice']);