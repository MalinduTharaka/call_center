<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceId;
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
        $invoices = Invoice::all();
        return view('call_center.new-orders', compact('orders', 'packages', 'users', 'slips', 'invoices'));
    }

    // public function storeB(Request $request)
    // {
    //     $order = Order::create([
    //         'order_type' => 'boosting',
    //         'date' => now(),
    //         'cro' => auth()->user()->role,
    //         'old_new' => 'new',
    //         'name' => $request->name,
    //         'contact' => $request->contact,
    //         'work_type' => $request->work_type,
    //         'work_status' => 'pending',
    //         'package_id' => $request->package_id,
    //         'payment_status' => $request->payment_status,
    //         'cash' => $request->cash,
    //         'advance' => $request->advance,
    //         'amount' => $request->amount,
    //         'page' => $request->page,
    //         'details' => $request->details,
    //     ]);

    //     return redirect()->route('invoiceads', ['id' => $order->id]);
    // }

    // public function storeA(Request $request)
    //     {
    //         $order = Order::create([
    //             'order_type' => 'designs',
    //             'date' => now(),
    //             'cro' => auth()->user()->role,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => $request->work_type,
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_status,
    //             'advance' => $request->advance,
    //             'amount' => $request->amount,
    //         ]);
    //         return redirect()->route('invoiceads', ['id' => $order->id]);
    //     }

    // public function storeV(Request $request)
    //     {
    //         $order = Order::create([
    //             'order_type' => 'video',
    //             'date' => now(),
    //             'cro' => auth()->user()->role,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => $request->work_type,
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_status,
    //             'cash' => $request->cash,
    //             'advance' => $request->advance,
    //             'amount' => $request->amount,
    //             'our_amount' => $request->our_amount,
    //             'script' => $request->script,
    //             'shoot' => 'pending',
    //         ]);
    //         return redirect()->route('invoicevideo', ['id' => $order->id]);
    //     }


    
    
    // public function store(Request $request)
    // {
    //     // Retrieve order type values from the request.
    //     $orderType1 = $request->has('order_type1');
    //     $orderType2 = $request->has('order_type2');
    //     $orderType3 = $request->has('order_type3');

    //     // Scenario 1: Only order_type1 is checked
    //     if ($orderType1 && !$orderType2 && !$orderType3) {
    //         $order = [
    //             'order_type' => 'boosting',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'old_new' => 'new',
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'boosting',
    //             'work_status' => 'pending',
    //             'package_id' => $request->package_id,
    //             'payment_status' => $request->payment_statusb,
    //             'cash' => $request->cashb,
    //             'advance' => $request->advanceb,
    //             'amount' => $request->amountb,
    //             'page' => $request->pageb,
    //             'details' => $request->detailsb,
    //         ];
    //         return redirect()->route('invoicesolo');
    //     }
    //     // Scenario 2: Only order_type2 is checked
    //     elseif (!$orderType1 && $orderType2 && !$orderType3) {
    //         $order = Order::create([
    //             'order_type' => 'designs',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'design',
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_statusa,
    //             'cash' => $request->casha,
    //             'advance' => $request->advancea,
    //             'amount' => $request->amounta,
    //         ]);
    //         return redirect()->route('invoicesolo', ['id' => $order->id]);
    //     }
    //     // Scenario 3: Only order_type3 is checked
    //     elseif (!$orderType1 && !$orderType2 && $orderType3) {
    //         $order = Order::create([
    //             'order_type' => 'video',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'video',
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_statusv,
    //             'cash' => $request->cashv,
    //             'advance' => $request->advancev,
    //             'amount' => $request->amountv,
    //             'our_amount' => $request->our_amountv,
    //             'script' => $request->scriptv,
    //             'shoot' => 'pending',
    //         ]);
    //         return redirect()->route('invoicesolo', ['id' => $order->id]);
    //     }
    //     // Scenario 4: order_type1 and order_type2 are checked
    //     elseif ($orderType1 && $orderType2 && !$orderType3) {
    //         $order1 = Order::create([
    //             'order_type' => 'boosting',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'old_new' => 'new',
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'boosting',
    //             'work_status' => 'pending',
    //             'package_id' => $request->package_id,
    //             'payment_status' => $request->payment_statusb,
    //             'cash' => $request->cashb,
    //             'advance' => $request->advanceb,
    //             'amount' => $request->amountb,
    //             'page' => $request->pageb,
    //             'details' => $request->detailsb,
    //         ]);

    //         $order2 = Order::create([
    //             'order_type' => 'designs',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'design',
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_statusa,
    //             'cash' => $request->casha,
    //             'advance' => $request->advancea,
    //             'amount' => $request->amounta,
    //         ]);
    //         return redirect()->route('invoicetwo', ['id1' => $order1->id, 'id2' => $order2->id]);
    //     }
    //     // Scenario 5: order_type1 and order_type3 are checked
    //     elseif ($orderType1 && !$orderType2 && $orderType3) {
    //         $order1 = Order::create([
    //             'order_type' => 'boosting',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'old_new' => 'new',
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'boosting',
    //             'work_status' => 'pending',
    //             'package_id' => $request->package_id,
    //             'payment_status' => $request->payment_statusb,
    //             'cash' => $request->cashb,
    //             'advance' => $request->advanceb,
    //             'amount' => $request->amountb,
    //             'page' => $request->pageb,
    //             'details' => $request->detailsb,
    //         ]);

    //         $order2 = Order::create([
    //             'order_type' => 'video',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'video',
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_statusv,
    //             'cash' => $request->cashv,
    //             'advance' => $request->advancev,
    //             'amount' => $request->amountv,
    //             'our_amount' => $request->our_amountv,
    //             'script' => $request->scriptv,
    //             'shoot' => 'pending',
    //         ]);

    //         return redirect()->route('invoicetwo', ['id1' => $order1->id, 'id2' => $order2->id]);
    //     }
    //     // Scenario 6: order_type2 and order_type3 are checked
    //     elseif (!$orderType1 && $orderType2 && $orderType3) {

    //         $order1 = Order::create([
    //             'order_type' => 'designs',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'design',
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_statusa,
    //             'cash' => $request->casha,
    //             'advance' => $request->advancea,
    //             'amount' => $request->amounta,
    //         ]);

    //         $order2 = Order::create([
    //             'order_type' => 'video',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'video',
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_statusv,
    //             'cash' => $request->cashv,
    //             'advance' => $request->advancev,
    //             'amount' => $request->amountv,
    //             'our_amount' => $request->our_amountv,
    //             'script' => $request->scriptv,
    //             'shoot' => 'pending',
    //         ]);

    //         return redirect()->route('invoicetwo', ['id1' => $order1->id, 'id2' => $order2->id]);
    //     }
    //     // Scenario 7: All three order types are checked
    //     elseif ($orderType1 && $orderType2 && $orderType3) {

    //         $order1 = Order::create([
    //             'order_type' => 'boosting',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'old_new' => 'new',
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'boosting',
    //             'work_status' => 'pending',
    //             'package_id' => $request->package_id,
    //             'payment_status' => $request->payment_statusb,
    //             'cash' => $request->cashb,
    //             'advance' => $request->advanceb,
    //             'amount' => $request->amountb,
    //             'page' => $request->pageb,
    //             'details' => $request->detailsb,
    //         ]);

    //         $order2 = Order::create([
    //             'order_type' => 'designs',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'design',
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_statusa,
    //             'cash' => $request->casha,
    //             'advance' => $request->advancea,
    //             'amount' => $request->amounta,
    //         ]);

    //         $order3 = Order::create([
    //             'order_type' => 'video',
    //             'date' => now(),
    //             'cro' => auth()->user()->id,
    //             'name' => $request->name,
    //             'contact' => $request->contact,
    //             'work_type' => 'video',
    //             'work_status' => 'pending',
    //             'payment_status' => $request->payment_statusv,
    //             'cash' => $request->cashv,
    //             'advance' => $request->advancev,
    //             'amount' => $request->amountv,
    //             'our_amount' => $request->our_amountv,
    //             'script' => $request->scriptv,
    //             'shoot' => 'pending',
    //         ]);

    //         return redirect()->route('invoiceall', ['id1' => $order1->id, 'id2' => $order2->id, 'id3' => $order3->id]);
    //     }

    //     return redirect()->back()->with('error', 'No order type selected.');
    // }

    
    public function store_solo(Request $request){
        $quantity = $request->input('quantity');

        $invoice = Invoice::create([
            'date' => $request->date,
            'contact' => $request->contact,
            'inv' => $request->inv,
            'total' => $request->total,
        ]);

        $invrw = InvoiceId::findOrFail($request->inv_no);
        $invrw->update(['status', 'submited']);
    
        for ($i = 0; $i < $quantity; $i++) {
            $orderData = [
                'order_type' => $request->order_type,
                'cro' => auth()->user()->cc_num,
                'date' => $request->date,
                'name' => $request->name,
                'contact' => $request->contact,
                'invoice' => $request->inv,
            ];

            if ($request->order_type === 'boosting') {
                $orderData = array_merge($orderData, [
                    'package_amt' => $request->package_amt,
                    'tax' => $request->tax / $quantity,
                    'service' => $request->service / $quantity,
                ]);
            } else {
                $orderData = array_merge($orderData, [
                    'amount' => $request->amount
                ]);
            }

            // Create order record
            Order::create($orderData);
        }

        return redirect('/new/orders')->with('success', 'Order created successfully');

    }

    public function store_two(Request $request){
        $quantity1 = $request->quantity1;
        $quantity2 = $request->quantity2;

        $invoice = Invoice::create([
            'date' => $request->date,
            'contact' => $request->contact,
            'inv' => $request->inv,
            'total' => $request->total,
        ]);

        $invrw = InvoiceId::findOrFail($request->inv_no);
        $invrw->update(['status', 'submited']);

        for ($i = 0; $i < $quantity1; $i++) {
            $orderData = [
                'order_type' => $request->order_type1,
                'cro' => auth()->user()->cc_num,
                'date' => $request->date,
                'name' => $request->name,
                'contact' => $request->contact,
                'invoice' => $request->inv,
            ];

            if ($request->order_type1 === 'boosting') {
                $orderData = array_merge($orderData, [
                    'package_amt' => $request->package_amt,
                    'tax' => $request->tax / $quantity1,
                    'service' => $request->service / $quantity1,
                ]);
            } else {
                $orderData = array_merge($orderData, [
                    'amount' => $request->amount
                ]);
            }

            // Create order record
            Order::create($orderData);
        }

        for ($i = 0; $i < $quantity2; $i++) {
            $orderData = [
                'order_type' => $request->order_type2,
                'date' => $request->date,
                'name' => $request->name,
                'contact' => $request->contact,
                'invoice' => $request->inv,
                'amount' => $request->amount
            ];

            // Create order record
            Order::create($orderData);
        }

        return redirect('/new/orders')->with('success', 'Order created successfully');

    }
    
    public function store_all(Request $request){
        $quantity1 = $request->quantity1;
        $quantity2 = $request->quantity2;
        $quantity3 = $request->quantity3;

        $invoice = Invoice::create([
            'date' => $request->date,
            'contact' => $request->contact,
            'inv' => $request->inv,
            'total' => $request->total,
        ]);

        $invrw = InvoiceId::findOrFail($request->inv_no);
        $invrw->update(['status', 'submited']);

        for ($i = 0; $i < $quantity1; $i++) {
            $orderData = [
                'order_type' => $request->order_type1,
                'cro' => auth()->user()->cc_num,
                'date' => $request->date,
                'name' => $request->name,
                'contact' => $request->contact,
                'invoice' => $request->inv,
                'package_amt' => $request->package_amt,
                'tax' => $request->tax / $quantity1,
                'service' => $request->service / $quantity1,
            ];

            // Create order record
            Order::create($orderData);
        }

        for ($i = 0; $i < $quantity2; $i++) {
            $orderData = [
                'order_type' => $request->order_type2,
                'date' => $request->date,
                'name' => $request->name,
                'contact' => $request->contact,
                'invoice' => $request->inv,
                'amount' => $request->amount2
            ];

            // Create order record
            Order::create($orderData);
        }

        for ($i = 0; $i < $quantity3; $i++) {
            $orderData = [
                'order_type' => $request->order_type3,
                'date' => $request->date,
                'name' => $request->name,
                'contact' => $request->contact,
                'invoice' => $request->inv,
                'amount' => $request->amount3
            ];

            // Create order record
            Order::create($orderData);
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

        return response()->json([
            'success' => true,
            'message' => 'Order #'.$id.' updated successfully!', // Customized message
            'data' => $order
        ]);
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

        return redirect()->back()->with('success', 'Order updated successfully!');
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

        return redirect()->back()->with('success', 'Order updated successfully!');
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
