<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceId;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Slip;
use function Symfony\Component\Clock\now;


class OrderConroller extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('call_center.new-orders', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types', 'video_pkgs'));
    }

    public function store_solo(Request $request){
        // Create the invoice record using the common details from the form
    // Create the invoice
    $invoice = Invoice::create([
        'date' => $request->date,
        'contact' => $request->contact,
        'inv' => $request->inv,
        'total' => $request->total,
    ]);

    // Update the InvoiceId status to 'submitted'
    $invrw = InvoiceId::findOrFail($request->inv_no);
    $invrw->update(['status' => 'submitted']);

    // Loop through each order in the request and save them
    foreach ($request->orders as $orderData) {
        $order = [
            'order_type' => $orderData['order_type'],
            'cro' => auth()->user()->cc_num,
            'date' => $request->date,
            'name' => $request->name,
            'contact' => $request->contact,
            'invoice' => $request->inv,
            'work_type' => $orderData['work_type'],
        ];

        // Set fields based on order type
        if ($orderData['order_type'] === 'boosting') {
            $order['package_amt'] = $orderData['package_amt'];
            $order['tax'] = $orderData['tax'];
            $order['service'] = $orderData['service'];
        }elseif($orderData['order_type'] === 'video'){
            $order['video_time'] = $orderData['time'];
            $order['amount'] = $orderData['amount'];
        } else {
            $order['amount'] = $orderData['amount'];
        }

        Order::create($order);
    }

    return redirect('/new/orders')->with('success', 'Orders created successfully');

    }

    public function store_two(Request $request) {
        // Create the invoice
        $invoice = Invoice::create([
            'date' => $request->date,
            'contact' => $request->contact,
            'inv' => $request->inv,
            'total' => $request->total,
        ]);
    
        // Update invoice ID status
        $invrw = InvoiceId::findOrFail($request->inv_no);
        $invrw->update(['status' => 'submitted']);
    
        // Process each order
        foreach ($request->orders as $orderData) {
            $order = [
                'order_type' => $orderData['order_type'],
                'cro' => auth()->user()->cc_num,
                'date' => $request->date,
                'name' => $request->name,
                'contact' => $request->contact,
                'invoice' => $request->inv,
                'work_type' => $orderData['work_type'],
            ];
    
            // Add type-specific fields
            if ($orderData['order_type'] === 'boosting') {
                $order['package_amt'] = $orderData['package_amt'];
                $order['tax'] = $orderData['tax'];
                $order['service'] = $orderData['service'];
            }elseif($orderData['order_type'] === 'video'){
                $order['video_time'] = $orderData['time'];
                $order['amount'] = $orderData['amount'];
            } else {
                $order['amount'] = $orderData['amount'];
            }
    
            Order::create($order);
        }
    
        return redirect('/new/orders')->with('success', 'Orders created successfully');
    

    }
    
    public function store_all(Request $request){
        // Create the invoice
        $invoice = Invoice::create([
            'date' => $request->date,
            'contact' => $request->contact,
            'inv' => $request->inv,
            'total' => $request->total,
        ]);
    
        // Update invoice ID status correctly
        $invrw = InvoiceId::findOrFail($request->inv_no);
        $invrw->update(['status' => 'submitted']);
    
        // Process each order submitted from the hidden inputs
        foreach ($request->orders as $orderData) {
            $order = [
                'order_type' => $orderData['order_type'],
                'cro' => auth()->user()->cc_num,
                'date' => $request->date,
                'name' => $request->name,
                'contact' => $request->contact,
                'invoice' => $request->inv,
                'work_type' => $orderData['work_type'],
            ];
    
            if ($orderData['order_type'] === 'boosting') {
                $order['package_amt'] = $orderData['package_amt'];
                $order['tax'] = $orderData['tax'];
                $order['service'] = $orderData['service'];
            }elseif($orderData['order_type'] === 'video'){
                $order['video_time'] = $orderData['time'];
                $order['amount'] = $orderData['amount'];
            } else {
                $order['amount'] = $orderData['amount'];
            }
    
            // Create order record
            Order::create($order);
        }
    
        return redirect('/new/orders')->with('success', 'Order created successfully');
    }
    
    
    public function updateBoostingOrders(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Updates all fields from the request

        if($request->payment_status == 'pending' || $request->payment_status == 'partial' || $request->payment_status == 'rejected'){
            $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
            $invoice->update(['status' => 'pending']);
            // $orders = Order::where('invoice', $request->inv)->firstOrFail();
            // $orders->update(['payment_status' => $request->payment_status]);
        }

        return response()->json(['success' => 'Order updated successfully!']);
    }

    public function updateDesignsOrders(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Updates all fields from the request

        if($request->payment_status == 'pending' || $request->payment_status == 'partial' || $request->payment_status == 'rejected'){
            $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
            $invoice->update(['status' => 'pending']);
            // $orders = Order::where('invoice', $request->inv)->firstOrFail();
            // $orders->update(['payment_status' => $request->payment_status]);
        }

        return response()->json(['success' => 'Order updated successfully!']);
    }

    public function updateVideoOrders(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Updates all fields from the request

        if($request->payment_status == 'pending' || $request->payment_status == 'partial' || $request->payment_status == 'rejected'){
            $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
            $invoice->update(['status' => 'pending']);
            // $orders = Order::where('invoice', $request->inv)->firstOrFail();
            // $orders->update(['payment_status' => $request->payment_status]);
        }

        return response()->json(['success' => 'Order updated successfully!']);
    }


    public function getOrderTypes($inv)
    {
        $orderTypes = Order::where('invoice', $inv)
                        ->distinct()
                        ->pluck('order_type')
                        ->toArray();

        return response()->json($orderTypes);
    }
}
