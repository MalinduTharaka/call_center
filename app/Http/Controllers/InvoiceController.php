<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Slip;

class InvoiceController extends Controller
{
    public function invoiceads($id)
{
    $order = Order::findOrFail($id);
    return view('call_center.invoice-ads', compact('order'));
}




public function invoicevideo($id)
{
    $order = Order::findOrFail($id);
    return view('call_center.invoice-video', compact('order'));
}

}