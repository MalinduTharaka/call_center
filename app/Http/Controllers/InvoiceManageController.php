<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use App\Models\Slip;
use App\Models\User;
use App\Models\WorkType;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceManageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        
        $user = User::all();
        $invoices = Invoice::whereBetween('date', [$from, $to])->get();
        $orders = Order::whereBetween('date', [$from, $to])->get();
        $slips = Slip::all();
        return view('call_center.invoice-manage', compact('user', 'invoices', 'orders', 'slips'));
    }

    // app/Http/Controllers/InvoiceManageController.php
public function invoiceView($inv)
{
    $work_types = WorkType::all();
    $invoices = Invoice::all();
    $orders = Order::where('invoice', $inv)
        ->select('order_type', 'invoice', 'date', 'name', 'contact', 'work_type_id', 'video_time', 'package_amt', 'service', 'tax', 'amount')
        ->get();
    
    return view('call_center.invoice-view', compact('orders', 'invoices', 'work_types'));
}
public function invoiceViewOR($inv)
{
    $work_types = WorkType::all();
    $invoices = Invoice::all();
    $orders = OtherOrder::where('invoice_id', $inv)
        ->select('work_type', 'invoice_id', 'date', 'name', 'contact', 'note', 'amount')
        ->get();
    
    return view('call_center.invoice-view-or', compact('orders', 'invoices', 'work_types'));
}


}
