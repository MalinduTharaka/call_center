<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\ActorsWorkDoneController;
use App\Http\Controllers\AddAccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertiserAllOrdersController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CroWorkDoneController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\DesignersWorkDoneController;
use App\Http\Controllers\DesignPaymentController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\AssignEmployeesController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\IncomeCalculatorController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceManageController;
use App\Http\Controllers\OrderConroller;
use App\Http\Controllers\OtherOrderController;
use App\Http\Controllers\OutsideAuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PDFGenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationManageController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SalaryRatesController;
use App\Http\Controllers\SlipController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\VideoEditorsWorkDoneController;
use App\Http\Controllers\WorkDoneController;
use App\Http\Controllers\UpdateCenterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoPackageController;
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
    Route::get('/dashboard', function () {
        $invoices = Invoice::all();
        return view('dashboard', compact('invoices'));
    })->name('dashboard');

    //Order Routes
    Route::get('/new/orders', [OrderConroller::class, 'index'])->name('new.orders');
    // Route::post('/store/boosting', [OrderConroller::class, 'storeB']);
    // Route::post('/store/designs', [OrderConroller::class, 'storeA']);
    // Route::post('/store/video', [OrderConroller::class, 'storeV']);
    // Route::post('/store/order', [OrderConroller::class, 'store']);
    Route::post('/order/store/solo', [OrderConroller::class, 'store_solo'])->name('order.store.solo');
    Route::post('/order/store/two', [OrderConroller::class, 'store_two'])->name('order.store.two');
    Route::post('/order/store/all', [OrderConroller::class, 'store_all'])->name('order.store.all');
    Route::put('/orders/boosting/update/{id}', [OrderConroller::class, 'updateBoostingOrders'])->name('orders.updateBoostingOrders');
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
    Route::post  ('/packages/store',[PackageController::class, 'storepkg']) ->name('packages.store');

    Route::put   ('/packages/update', [PackageController::class, 'updatepkg']) ->name('packages.update');

    // delete
    Route::delete('/packages/delete/{id}', [PackageController::class, 'deletepkg']) ->name('packages.delete');

    //Invoice Routes
    // Route::get('/invoice-solo/{id}', [InvoiceController::class, 'invoicesolo'])->name('invoicesolo');
    // Route::get('/invoice-two/{id1}/{id2}', [InvoiceController::class, 'invoicetwo'])->name('invoicetwo');
    // Route::get('/invoice-all/{id1}/{id2}/{id3}', [InvoiceController::class, 'invoiceall'])->name('invoiceall');
    Route::post('/new_invoice', [InvoiceController::class, 'new_invoice']);

    //Slip Routes
    Route::post('/slip/update', [SlipController::class, 'store'])->name('upload.slip');
    Route::get('/orders/get-order-types/{inv}', [OrderConroller::class, 'getOrderTypes']);
    Route::post('/delete/slip/orders', [SlipController::class, 'deleteslp']);
    Route::post('/delete/slip/or', [SlipController::class, 'deleteORslp']);
    Route::get('/orders/get-slips/{invoice}', [SlipController::class, 'getSlips'])->name('orders.getSlips');

    //Notification Routes
    Route::post('/invoice/mark-read', [InvoiceController::class, 'markAsRead'])->name('invoice.markRead');

    //Update Center Routes
    Route::get('/update-center', [UpdateCenterController::class, 'index']);
    Route::put('/video/update/uc/{id}', [UpdateCenterController::class, 'updateVideoUC'])->name('uc.update.video');
    Route::put('/designs/update/uc/{id}', [UpdateCenterController::class, 'updateDesignsUC'])->name('uc.update.designs');

    //Centers Routes
    Route::get('/employees/centers', [AssignEmployeesController::class, 'index']);
    Route::post('/store/cc', [AssignEmployeesController::class, 'storecc']);
    Route::post('/store/ac', [AssignEmployeesController::class, 'storeac']);
    Route::put('/edit/cc/{id}', [AssignEmployeesController::class, 'updatecc']);
    Route::put('/edit/ac/{id}', [AssignEmployeesController::class, 'updateac']);
    Route::delete('/delete/cc/{id}', [AssignEmployeesController::class, 'deletecc']);
    Route::delete('/elete/ac/{id}', [AssignEmployeesController::class, 'deleteac']);

    //User Manage Routes
    Route::get('/users/manage', [UserController::class, 'index'])->name('users.index');
    Route::post('/store/user', [UserController::class, 'store'])->name('users.store');
    Route::put('/assign/user/{id}', [UserController::class, 'assignUser'])->name('users.assign');
    Route::delete('/delete/user/{id}', [UserController::class, 'deleteUser'])->name('users.destroy');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::put('/update/date/range/{id}', [UserController::class, 'dateRange'])->name('users.dateRange');

    //Invoice Manage Routes
    Route::get('/invoices/manage', [InvoiceManageController::class, 'index'])->name('invoices.index');
    Route::get('/invoice/view/{inv}', [InvoiceManageController::class, 'invoiceView'])->name('invoices.view');
    Route::post('/invoices/{invoice}/duplicate', [InvoiceController::class, 'duplicate'])->name('invoices.duplicate');

    //Quotation Manage Routes
    Route::get('/quotation/manage', [QuotationManageController::class, 'index'])->name('quotation.index');
    Route::get('/quotation/view/{inv}', [QuotationManageController::class, 'quotationView'])->name('quotation.view');
    Route::get('/qutToInv/{inv}', [QuotationManageController::class, 'qutToInv'])->name('qutToInv');

    //Advertiser Routes
    Route::get('/advertisers/manage', [AdvertiserController::class, 'index'])->name('advertisers.index');
    Route::get('/advertisers/design/view', [AdvertiserController::class, 'advertiserDesignView'])->name('advertisers.designView');
    Route::put('/advertisers/update/{id}', [AdvertiserController::class, 'updateAdv'])->name('advertisers.update');
    Route::get('/advertisers_all_order/manage', [AdvertiserAllOrdersController::class, 'index'])->name('advertisers.index');
    Route::put('/advertisers_all_order/update/{id}', [AdvertiserAllOrdersController::class, 'updateAdvAll'])->name('advertisers.update');
    Route::get('/advertisers_all_order/body', [AdvertiserAllOrdersController::class, 'body'])->name('advertisers_all_order.body');


    //Other Order Routes
    Route::get('/other_orders', [OtherOrderController::class, 'index']);
    Route::post('/other_invoice', [OtherOrderController::class, 'otherInvoice']);
    Route::post('/other_invoice/store', [OtherOrderController::class, 'storeOI'])->name('store.ot');
    Route::put('/other_order/update/{id}', [OtherOrderController::class, 'updateOI']);
    Route::post('/storeor/slip', [SlipController::class, 'storeOR'])->name('storeor');
    Route::get('/invoice/view/or/{inv}', [InvoiceManageController::class, 'invoiceViewOR'])->name('invoices.viewOR');
    Route::get('/quotation/view/or/{inv}', [QuotationManageController::class, 'quotationViewOR'])->name('quotation.viewOR');

    //workDone Routes
    Route::get('/workDone', [WorkDoneController::class, 'index']);

    //Editors Work CRUD
    Route::get('/video-editors-work', [VideoEditorsWorkDoneController::class, 'index'])->name('video.editors.index');
    Route::post('/video-editors-work/store', [VideoEditorsWorkDoneController::class, 'store'])->name('video.editors.store');
    Route::post('/video-editors-work/update/{editorsWork}', [VideoEditorsWorkDoneController::class, 'update'])->name('video.editors.update');
    Route::delete('/video-editors-work/delete/{editorsWork}', [VideoEditorsWorkDoneController::class, 'destroy'])->name('video.editors.destroy');

    // Actors Work CRUD
    Route::get('/actors-work', [ActorsWorkDoneController::class, 'index'])->name('actor.work.index');
    Route::post('/actors-work/store', [ActorsWorkDoneController::class, 'store'])->name('actor.work.store');
    Route::post('/actors-work/update/{actorsWork}', [ActorsWorkDoneController::class, 'update'])->name('actor.work.update');
    Route::delete('/actors-work/delete/{actorsWork}', [ActorsWorkDoneController::class, 'destroy'])->name('actor.work.destroy');

    // Target CRUD
    Route::get('/targets', [TargetController::class, 'index'])->name('target.index');
    Route::post('/targets/store', [TargetController::class, 'store'])->name('target.store');
    Route::post('/targets/update/{target}', [TargetController::class, 'update'])->name('target.update');
    Route::delete('/targets/delete/{target}', [TargetController::class, 'destroy'])->name('target.destroy');

    // Design payment CRUD
    Route::get('/design‑payments', [DesignPaymentController::class, 'index'])->name('design.payments.index');
    Route::post('/design‑payments/store', [DesignPaymentController::class, 'store'])->name('design.payments.store');
    Route::put('/design‑payments/update/{designPayment}', [DesignPaymentController::class, 'update'])->name('design.payments.update');
    Route::delete('/design‑payments/delete/{designPayment}', [DesignPaymentController::class, 'destroy'])->name('design.payments.destroy');

    // Designers work done
    Route::get('/designer-work', [DesignersWorkDoneController::class, 'index'])->name('designer.work.index');

    Route::get('/cro-work', [CroWorkDoneController::class, 'index'])->name('cro.work.index');

    //Profile Routes
    Route::get('/profile', [ProfileController::class,'index']);

    //Designer Routes
    Route::get('/designers', [DesignerController::class,'index']);
    Route::put('/orders/update/designers/{id}', [DesignerController::class, 'updareDesigner'])->name('orders.update.designer');
    Route::put('/design/upload/{id}', [DesignerController::class, 'DesignImageUpload'])->name('design.upload');

    //Income Routes
    Route::get('/incomes', [IncomeController::class, 'index'])->name('incomes.index');

    //Accountant Routes
    Route::get('/accountant', [AccountantController::class, 'index'])->name('accountant.index');
    Route::get('/accountant/or', [AccountantController::class, 'indexOR'])->name('accountant.indexOR');
    Route::put('/accountant/updateB/{id}', [AccountantController::class, 'accUpdateB'])->name('accountant.updateB');
    Route::put('/accountant/updateD/{id}', [AccountantController::class, 'accUpdateD'])->name('accountant.updateD');
    Route::put('/accountant/updateV/{id}', [AccountantController::class, 'accUpdateV'])->name('accountant.updateV');
    Route::put('accountant/other_order/update/{id}', [AccountantController::class, 'accUpdateOR'])->name('accountant.updateOR');

    //Video package controller
    Route::get('/video-packages', [VideoPackageController::class, 'index'])->name('video-packages.index');
    Route::post('/video-packages', [VideoPackageController::class, 'store'])->name('video-packages.store');
    Route::put('/video-packages/{id}', [VideoPackageController::class, 'update'])->name('video-packages.update');
    Route::delete('/video-packages/{id}', [VideoPackageController::class, 'destroy'])->name('video-packages.destroy');

    //TimeSlot Crud
    Route::get('/time-slots', [TimeSlotController::class, 'index'])->name('time-slots.index');
    Route::post('/time-slots', [TimeSlotController::class, 'store'])->name('time-slots.store');
    Route::put('/time-slots/{timeSlot}', [TimeSlotController::class, 'update'])->name('time-slots.update');
    Route::delete('/time-slots/{timeSlot}', [TimeSlotController::class, 'destroy'])->name('time-slots.destroy');

    //Admin Routes
    Route::get('/admin/orders', [AdminController::class, 'indexo'])->name('admin.orders');
    Route::put('/admin/orders/updateB/{id}', [AdminController::class, 'updateBoostingAD']);
    Route::put('/admin/orders/updateD/{id}', [AdminController::class, 'updateDesignsAD']);
    Route::put('/admin/orders/updateV/{id}', [AdminController::class, 'updateVideoAD']);
    Route::put('/admin/orders/updateOR/{id}', [AdminController::class, 'updateOrAD']);
    Route::get('/admin/orders/or', [AdminController::class, 'indexOR'])->name('admin.ordersOR');
    Route::post('/admin/update/sheet/add', [AdminController::class, 'BoostingUpdateSheet']);
    Route::get('/update/sheet', [AdminController::class, 'updateSheetView'])->name('updatesheetView');
    Route::put('/update/sheet/update/{id}', [AdminController::class, 'BoostingUpdateSheetEdit']);
    
    //Payment Edit Routes
    Route::put('/edit/payment/orders/{inv}', [AdminController::class, 'updatepaymentO']);
    Route::put('/edit/payment/or/{inv}', [AdminController::class, 'updatepaymentOR']);

    //Salary Rate Routes
    Route::get('/salary-rates', [SalaryRatesController::class, 'index']);
    Route::post('/salary-rates/store', [SalaryRatesController::class, 'store']);
    Route::put('/salary-rates/update/{id}', [SalaryRatesController::class, 'update']);
    Route::delete('/salary-rates/delete/{id}', [SalaryRatesController::class, 'delete']);

    //Refund Routes
    Route::get('/refund/orders/view', [RefundController::class, 'indexOrders']);
    Route::get('/refund/orders/OR/view', [RefundController::class, 'indexOR']);
    Route::post('/refund/orders', [RefundController::class, 'refundOrders']);
    Route::post('/refund/orders/OR', [RefundController::class, 'refundOtherOrders']);

    //Pdf Maker Routes
    Route::get('/pdf-maker', [PDFGenController::class, 'index']);

    //Attendance Routes
    Route::get('/attendance/today/view', [AttendanceController::class, 'indextodayattendance'])->name('attendance.today.index');
    Route::put('/attendance/today/update/{id}', [AttendanceController::class, 'editTodayAtt'])->name('attendance.update.today');
    Route::delete('/attendance/today/delete/{id}', [AttendanceController::class, 'deleteTodayAtt'])->name('attendance.delete.today');
    Route::post('/addAttendance/add', [AttendanceController::class, 'addAttendanceAdd'])->name('attendance.add');
    Route::get('/attendance/report/view', [AttendanceController::class, 'indexAttendanceReport'])->name('attendance.report');
    Route::get('/attendance/this-month/{id}', [AttendanceController::class, 'thisMonth'])->name('attendance.thisMonth');
    Route::post('/attendance/month/{id}', [AttendanceController::class, 'attendanceMonth'])->name('attendance.attendanceMonth');

    //Salary Routes
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salary.index');
    Route::get('/salaries/selected-month/{mo}/{yr}', [SalaryController::class, 'selectedMonth']);
    Route::put('/salary/edit/{id}', [SalaryController::class, 'editSalary']);
    Route::get('/net/income/calculator', [IncomeCalculatorController::class, 'index'])->name('net.income.calculator');

});



Route::post('/verify-device', [DeviceController::class, 'verifyDevice']);
Route::get('/check-device', [DeviceController::class, 'checkDevice']);
Route::get('/login/external', [OutsideAuthController::class, 'index']);
Route::post('/outside-login/verify', [OutsideAuthController::class, 'verifyEmail'])->name('outside.login.verify');
Route::get('/attendance/{id}', [AttendanceController::class, 'attendance'])->name('attendance');