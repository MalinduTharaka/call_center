<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $today = Carbon::now();
        $invoices = Invoice::all();
        $orders = Order::where('ps', '1')->get(); 
        $ordersb = Order::where('ps', 1)
                    ->where('order_type', 'boosting')
                    ->whereYear('date',  $today->year)
                    ->whereMonth('date', $today->month)
                    ->get();
        $ordersd = Order::where('ps', '1')
                    ->where('order_type', 'designs')
                    ->whereYear('date',  $today->year)
                    ->whereMonth('date', $today->month)
                    ->get();
        $ordersv = Order::where('ps', '1')
                    ->where('order_type', 'video')
                    ->whereYear('date',  $today->year)
                    ->whereMonth('date', $today->month)
                    ->get();

        $other_orders = OtherOrder::where('ps', '1')
                    ->whereYear('date',  $today->year)
                    ->whereMonth('date', $today->month)
                    ->get();

        $b_income = $ordersb->sum(function ($order) {
            if ($order->payment_status === 'done') {
                return $order->package_amt + $order->tax + $order->service;
            }
            return $order->advance;
        });
        $d_income = $ordersd->sum(function ($order) {
            if ($order->payment_status === 'done') {
                return $order->amount;
            }
            return $order->advance;
        });
        $v_income = $ordersv->sum(function ($order) {
            if ($order->payment_status === 'done') {
                return $order->amount;
            }
            return $order->advance;
        });

        $o_income = $other_orders->sum(function ($order) {
            if ($order->payment_status === 'done') {
                return $order->amount;
            }
            return $order->advance;
        });



        return view('admin.incomes', compact('invoices', 'orders', 'other_orders', 'b_income', 'd_income', 'v_income', 'o_income'));

    }
}
