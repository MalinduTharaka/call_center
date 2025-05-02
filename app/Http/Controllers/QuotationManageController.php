<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use App\Models\Slip;
use App\Models\User;
use App\Models\WorkType;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuotationManageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $user = User::all();
        $invoices = Invoice::whereBetween('date', [$from, $to])->get();
        $orders = Order::all();
        $slips = Slip::all();
        return view('call_center.quotation-manage', compact('user', 'invoices', 'orders', 'slips'));
    }

    // app/Http/Controllers/InvoiceManageController.php
    public function quotationView($inv)
    {
        $work_types = WorkType::all();
        $invoices = Invoice::all();
        $orders = Order::where('invoice', $inv)
            ->select('order_type', 'invoice', 'date', 'name', 'contact', 'work_type_id', 'video_time', 'package_amt', 'service', 'tax', 'amount')
            ->get();

        return view('call_center.quotation-view', compact('orders', 'invoices', 'work_types'));
    }

    public function quotationViewOR($inv)
{
    $work_types = WorkType::all();
    $invoices = Invoice::all();
    $orders = OtherOrder::where('invoice_id', $inv)
        ->select('work_type', 'invoice_id', 'date', 'name', 'contact', 'note', 'amount')
        ->get();
    
    return view('call_center.invoice-view-or', compact('orders', 'invoices', 'work_types'));
}

    public function qutToInv($inv){
        $invoice = Invoice::where('inv', $inv)->firstOrFail(); // Get the actual invoice instance
        $invoice->type = 0; // Change the type
        $invoice->save(); // Save the change
    
        return redirect()->route('invoices.index')->with('success', 'Invoice converted successfully.');
    }
    
}
