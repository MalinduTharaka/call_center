<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountantController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::whereBetween('created_at', [$from, $to])
        ->where('ps', '1')
        ->orderBy('created_at', 'desc')->get();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        return view('accountant.accountant', compact('orders', 'invoices'));
    }
    public function indexOR()
    {
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();
        $other_orders = OtherOrder::whereBetween('created_at', [$from, $to])
        ->where('ps', '1')
        ->orderBy('created_at', 'desc')->get();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        return view('accountant.accountantOR', compact(   'invoices', 'other_orders'));
    }

    public function accUpdateB(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json([
            'success' => true,
            'order' => $order->fresh()
        ]);
    }
    public function accUpdateD(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json([
            'success' => true,
            'order' => $order->fresh()
        ]);
    }
    public function accUpdateV(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json([
            'success' => true,
            'order' => $order->fresh()
        ]);
    }
    public function accUpdateOR(Request $request, $id)
    {
        $other_order = OtherOrder::findOrFail($id);
        $other_order->update([
            'ce' => $request->ce,
        ]);
        return redirect()->back()->with('success', 'Other Order Updated Successfully');
    }
}
