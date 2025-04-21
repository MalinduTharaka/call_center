<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Slip;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceManageController extends Controller
{
    public function index(){
        $user = User::all();
        $invoices = Invoice::all();
        $orders = Order::all();
        $slips = Slip::all();
        return view('call_center.invoice-manage', compact('user', 'invoices', 'orders', 'slips'));
    }
}
