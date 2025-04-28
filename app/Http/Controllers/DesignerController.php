<?php

namespace App\Http\Controllers;

use App\Events\DesignersPaymentsUpdateEvent;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\WorkType;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        return view('designers.designer', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types'));
    }

    public function updareDesigner(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Updates all fields from the request

        event(new DesignersPaymentsUpdateEvent($id));
        
        return redirect()->back()->with('success', 'Order Updated Successfully');
    }
}
