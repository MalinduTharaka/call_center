<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Slip;


class OrderConroller extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        return view('call_center.new-orders', compact('orders', 'packages', 'users', 'slips'));
    }

    public function storeB(Request $request)
    {
        $order = Order::create([
            'order_type' => 'boosting',
            'date' => now(),
            'cro' => auth()->user()->role,
            'old_new' => 'new',
            'name' => $request->name,
            'contact' => $request->contact,
            'work_type' => $request->work_type,
            'work_status' => 'pending',
            'package_id' => $request->package_id,
            'payment_status' => $request->payment_status,
            'cash' => $request->cash,
            'advance' => $request->advance,
            'amount' => $request->amount,
            'page' => $request->page,
            'details' => $request->details,
        ]);
        
        return redirect()->route('invoiceads', ['id' => $order->id]);
    }

    public function storeA(Request $request)
    {
        $order = Order::create([
            'order_type' => 'designs',
            'date' => now(),
            'cro' => auth()->user()->role,
            'name' => $request->name,
            'contact' => $request->contact,
            'work_type' => $request->work_type,
            'work_status' => 'pending',
            'payment_status' => $request->payment_status,
            'advance' => $request->advance,
            'amount' => $request->amount,
        ]);
        return redirect()->route('invoiceads', ['id' => $order->id]);
    }

    public function storeV(Request $request)
    {
        $order = Order::create([
            'order_type' => 'video',
            'date' => now(),
            'cro' => auth()->user()->role,
            'name' => $request->name,
            'contact' => $request->contact,
            'work_type' => $request->work_type,
            'work_status' => 'pending',
            'payment_status' => $request->payment_status,
            'cash' => $request->cash,
            'advance' => $request->advance,
            'amount' => $request->amount,
            'our_amount' => $request->our_amount,
            'script' => $request->script,
            'shoot' => 'pending',
        ]);
        return redirect()->route('invoicevideo', ['id' => $order->id]);
    }

    public function updateBoostingOrders(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Updates all fields from the request

        return redirect()->back()->with('success', 'Order updated successfully!');
    }

    public function updateDesignsOrders(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Updates all fields from the request

        return redirect()->back()->with('success', 'Order updated successfully!');
    }

    public function updateVideoOrders(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Updates all fields from the request

        return redirect()->back()->with('success', 'Order updated successfully!');
    }
}
