<?php

use App\Http\Controllers\AddAccountController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderConroller;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SlipController;
use App\Http\Controllers\WorkTypeController;
use Illuminate\Support\Facades\Route;
use App\Models\Invoice;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () { $invoices = Invoice::all(); return view('dashboard', compact('invoices')); })->name('dashboard');

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
    // Route::get('/invoice-solo/{id}', [InvoiceController::class, 'invoicesolo'])->name('invoicesolo');
    // Route::get('/invoice-two/{id1}/{id2}', [InvoiceController::class, 'invoicetwo'])->name('invoicetwo');
    // Route::get('/invoice-all/{id1}/{id2}/{id3}', [InvoiceController::class, 'invoiceall'])->name('invoiceall');
    Route::post('/new_invoice', [InvoiceController::class, 'new_invoice']);

    //Slip Routes
    Route::post('/slip/update', [SlipController::class, 'store'])->name('upload.slip');

    Route::get('/orders/get-order-types/{inv}', [OrderConroller::class, 'getOrderTypes']);

    //Notification Routes
    Route::post('/invoice/mark-read', [InvoiceController::class, 'markAsRead'])->name('invoice.markRead');

});



Route::post('/verify-device', [DeviceController::class, 'verifyDevice']);
Route::get('/check-device', [DeviceController::class, 'checkDevice']);