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
    // Route::post('/store/boosting', [OrderConroller::class, 'storeB']);
    // Route::post('/store/designs', [OrderConroller::class, 'storeA']);
    // Route::post('/store/video', [OrderConroller::class, 'storeV']);
    // Route::post('/store/order', [OrderConroller::class, 'store']);
    Route::post('/order/store/solo', [OrderConroller::class, 'store_solo'])->name('order.store.solo');
    Route::post('/order/store/two', [OrderConroller::class, 'store_two'])->name('order.store.two');
    Route::post('/order/store/all', [OrderConroller::class, 'store_all'])->name('order.store.all');
    Route::put('/orders/boosting/update/{id}', [OrderConroller::class, 'updateBoostingOrders'])->name('orders.update');
    Route::put('/orders/designs/update/{id}', [OrderConroller::class, 'updateDesignsOrders'])->name('orders.update.designs');
    Route::put('/orders/video/update/{id}', [OrderConroller::class, 'updateVideoOrders'])->name('orders.update.video');

    //Work Type Routes
    Route::get('/work-types', [WorkTypeController::class, 'index']);

    //Add Account Routes
    Route::get('/add-account', [AddAccountController::class, 'index']);

    //Package Routes
    Route::get('/packages', [PackageController::class, 'index']);


    //Invoice Routes
    // Route::get('/invoice-solo/{id}', [InvoiceController::class, 'invoicesolo'])->name('invoicesolo');
    // Route::get('/invoice-two/{id1}/{id2}', [InvoiceController::class, 'invoicetwo'])->name('invoicetwo');
    // Route::get('/invoice-all/{id1}/{id2}/{id3}', [InvoiceController::class, 'invoiceall'])->name('invoiceall');
    Route::post('/new_invoice', [InvoiceController::class, 'new_invoice']);

    //Slip Routes
    Route::post('/slip/update', [SlipController::class, 'store'])->name('upload.slip');

    Route::get('/orders/get-order-types/{inv}', [OrderConroller::class, 'getOrderTypes']);
});



Route::post('/verify-device', [DeviceController::class, 'verifyDevice']);
Route::get('/check-device', [DeviceController::class, 'checkDevice']);