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
    Route::get('/work-types', [WorkTypeController::class, 'index']);

    //Add Account Routes
    Route::get('/add-account', [AddAccountController::class, 'index']);

    //Package Routes
    Route::get('/packages', [PackageController::class, 'index']);
    Route::post  ('/packages/store',[PackageController::class, 'storepkg']) ->name('packages.store');

    Route::put   ('/packages/update', [PackageController::class, 'updatepkg']) ->name('packages.update');

    // delete
    Route::delete('/packages/delete/{id}', [PackageController::class, 'deletepkg']) ->name('packages.delete');

    //Invoice Routes
    Route::get('/invoice-ads/{id}', [InvoiceController::class, 'invoiceads'])->name('invoiceads');
    Route::get('/invoice-video/{id}', [InvoiceController::class, 'invoicevideo'])->name('invoicevideo');

    //Slip Routes
    Route::post('/upload-slip/{order}', [SlipController::class, 'store'])->name('upload.slip');
});



Route::post('/verify-device', [DeviceController::class, 'verifyDevice']);
Route::get('/check-device', [DeviceController::class, 'checkDevice']);