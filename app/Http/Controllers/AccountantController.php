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
use Illuminate\Http\Request;

class AccountantController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $other_orders = OtherOrder::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('accountant.accountant', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types', 'video_pkgs', 'other_orders'));
    }
    public function indexOR()
    {
        $orders = Order::all();
        $other_orders = OtherOrder::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('accountant.accountantOR', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types', 'video_pkgs', 'other_orders'));
    }

    public function accUpdateB(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return redirect()->back()->with('success', 'Boosting Order Updated Successfully');
    }
    public function accUpdateD(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return redirect()->back()->with('success', 'Designs Order Updated Successfully');
    }
    public function accUpdateV(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return redirect()->back()->with('success', 'Video Order Updated Successfully');
    }
    public function accUpdateOR(Request $request, $id)
    {
        $other_order = OtherOrder::findOrFail($id);
        $other_order->update($request->all());
        return redirect()->back()->with('success', 'Other Order Updated Successfully');
    }
}
