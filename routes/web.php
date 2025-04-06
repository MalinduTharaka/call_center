<?php

use App\Http\Controllers\AddAccountController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderConroller;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SlipController;
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
    Route::get('/new/orders', [OrderConroller::class, 'index']);
    Route::post('/store/boosting', [OrderConroller::class, 'storeB']);
    Route::post('/store/designs', [OrderConroller::class, 'storeA']);
    Route::post('/store/video', [OrderConroller::class, 'storeV']);
    Route::put('/orders/boosting/update/{id}', [OrderConroller::class, 'updateBoostingOrders'])->name('orders.update');
    Route::put('/orders/designs/update/{id}', [OrderConroller::class, 'updateDesignsOrders'])->name('orders.update.designs');
    Route::put('/orders/video/update/{id}', [OrderConroller::class, 'updateVideoOrders'])->name('orders.update.video');

    //Work Type Routes
    Route::get('/work-types', [WorkTypeController::class, 'index'])->name('work-types.index');
    Route::post('/store/work-types', [WorkTypeController::class, 'store'])->name('work-types.store');
    Route::get('/work-types/{id}/edit', [WorkTypeController::class, 'edit'])->name('work-types.edit');
    Route::put('/work-types/{workType}', [WorkTypeController::class, 'update'])->name('work-types.update');
    Route::delete('/work-types/{workType}', [WorkTypeController::class, 'destroy'])->name('work-types.destroy');
    

    //Add Account Routes
    Route::get('/add-account', [AddAccountController::class, 'index']);
    Route::post('/store/add-account', [AddAccountController::class, 'store'])->name('account.store');
    Route::get('/add-account/{id}/edit', [AddAccountController::class, 'edit'])->name('account.edit');
    Route::put('/add-account/{id}', [AddAccountController::class, 'update'])->name('account.update');
    Route::delete('/add-account/{id}', [AddAccountController::class, 'destroy'])->name('account.destroy');

    //Package Routes
    Route::get('/packages', [PackageController::class, 'index']);

    //Invoice Routes
    Route::get('/invoice-ads/{id}', [InvoiceController::class, 'invoiceads'])->name('invoiceads');
    Route::get('/invoice-video/{id}', [InvoiceController::class, 'invoicevideo'])->name('invoicevideo');

    //Slip Routes
    Route::post('/upload-slip/{order}', [SlipController::class, 'store'])->name('upload.slip');
});



Route::post('/verify-device', [DeviceController::class, 'verifyDevice']);
Route::get('/check-device', [DeviceController::class, 'checkDevice']);