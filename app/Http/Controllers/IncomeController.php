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

        // --- MONTHLY DATA ---
        // All invoices (if you still need these)
        $invoices = Invoice::all();

        // All paid orders (ps = 1) for the current month
        $ordersb_month = Order::where('ps', 1)
            ->where('order_type', 'boosting')
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->get();

        $ordersd_month = Order::where('ps', 1)
            ->where('order_type', 'designs')
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->get();

        $ordersv_month = Order::where('ps', 1)
            ->where('order_type', 'video')
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->get();

        $other_orders_month = OtherOrder::where('ps', 1)
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->get();

        // --- TODAY’S DATA ---
        $ordersb_today = Order::where('ps', 1)
            ->where('order_type', 'boosting')
            ->whereDate('date', $today->toDateString())
            ->get();

        $ordersd_today = Order::where('ps', 1)
            ->where('order_type', 'designs')
            ->whereDate('date', $today->toDateString())
            ->get();

        $ordersv_today = Order::where('ps', 1)
            ->where('order_type', 'video')
            ->whereDate('date', $today->toDateString())
            ->get();

        $other_orders_today = OtherOrder::where('ps', 1)
            ->whereDate('date', $today->toDateString())
            ->get();

        // --- MONTHLY SUMS ---
        $b_income_pkg_month = $ordersb_month->sum(function ($order) {
            return $order->payment_status === 'done'
                ? $order->package_amt
                : ($order->advance - ($order->tax + $order->service));
        });

        $b_income_tax_month = $ordersb_month->sum->tax;
        $b_income_service_month = $ordersb_month->sum->service;

        $d_income_month = $ordersd_month->sum(function ($order) {
            return $order->payment_status === 'done'
                ? $order->amount
                : $order->advance;
        });

        $v_income_amt_month = $ordersv_month->sum(function ($order) {
            return $order->payment_status === 'done'
                ? $order->amount
                : $order->advance;
        });

        $v_income_our_amt_month = $ordersv_month->sum->our_amount;

        $o_income_month = $other_orders_month->sum(function ($order) {
            return $order->payment_status === 'done'
                ? $order->amount
                : $order->advance;
        });

        // --- TODAY’S SUMS ---
        $b_income_pkg_today = $ordersb_today->sum(function ($order) {
            return $order->payment_status === 'done'
                ? $order->package_amt
                : ($order->advance - ($order->tax + $order->service));
        });

        $b_income_tax_today = $ordersb_today->sum->tax;
        $b_income_service_today = $ordersb_today->sum->service;

        $d_income_today = $ordersd_today->sum(function ($order) {
            return $order->payment_status === 'done'
                ? $order->amount
                : $order->advance;
        });

        $v_income_amt_today = $ordersv_today->sum(function ($order) {
            return $order->payment_status === 'done'
                ? $order->amount
                : $order->advance;
        });

        $v_income_our_amt_today = $ordersv_today->sum->our_amount;

        $o_income_today = $other_orders_today->sum(function ($order) {
            return $order->payment_status === 'done'
                ? $order->amount
                : $order->advance;
        });

        // BOOSTING counts
        $boostCountMonth = Order::where('ps', 1)
            ->where('order_type', 'boosting')
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->count();

        $boostCountToday = Order::where('ps', 1)
            ->where('order_type', 'boosting')
            ->whereDate('date', $today->toDateString())
            ->count();

        // DESIGNS counts
        $designCountMonth = Order::where('ps', 1)
            ->where('order_type', 'designs')
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->count();

        $designCountToday = Order::where('ps', 1)
            ->where('order_type', 'designs')
            ->whereDate('date', $today->toDateString())
            ->count();

        // VIDEO counts
        $videoCountMonth = Order::where('ps', 1)
            ->where('order_type', 'video')
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->count();

        $videoCountToday = Order::where('ps', 1)
            ->where('order_type', 'video')
            ->whereDate('date', $today->toDateString())
            ->count();

        // OTHER ORDERS counts
        $otherCountMonth = OtherOrder::where('ps', 1)
            ->whereYear('date', $today->year)
            ->whereMonth('date', $today->month)
            ->count();

        $otherCountToday = OtherOrder::where('ps', 1)
            ->whereDate('date', $today->toDateString())
            ->count();


        return view('admin.incomes', compact(
            // raw collections if needed
            'invoices',

            // monthly totals
            'b_income_pkg_month',
            'b_income_tax_month',
            'b_income_service_month',
            'd_income_month',
            'v_income_amt_month',
            'v_income_our_amt_month',
            'o_income_month',

            // today’s totals
            'b_income_pkg_today',
            'b_income_tax_today',
            'b_income_service_today',
            'd_income_today',
            'v_income_amt_today',
            'v_income_our_amt_today',
            'o_income_today',

            //Counts
            'boostCountMonth',
            'boostCountToday',
            'designCountMonth',
            'designCountToday',
            'videoCountMonth',
            'videoCountToday',
            'otherCountMonth',
            'otherCountToday'
        ));
    }

}
