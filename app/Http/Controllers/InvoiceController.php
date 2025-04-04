<?php

namespace App\Http\Controllers;

use App\Models\InvoiceId;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Slip;

class InvoiceController extends Controller
{
    public function invoicesolo($id){
        $order = Order::findOrFail($id);
        return view('call_center.invoice-solo', compact('order'));
    }

    public function invoicetwo($id1, $id2){
        $order1 = Order::findOrFail($id1);
        $order2 = Order::findOrFail($id2);
        return view('call_center.invoice-two', compact('order1', 'order2'));
    }

    public function invoiceall($id1, $id2, $id3){
        $order1 = Order::findOrFail($id1);
        $order2 = Order::findOrFail($id2);
        $order3 = Order::findOrFail($id3);
        return view('call_center.invoice-all', compact('order1', 'order2', 'order3'));
    }

    public function new_invoice(Request $request)
    {
        // Retrieve order type values from the request.
        $orderType1 = $request->has('order_type1');
        $orderType2 = $request->has('order_type2');
        $orderType3 = $request->has('order_type3');

        // Scenario 1: Only order_type1 is checked
        if ($orderType1 && !$orderType2 && !$orderType3) {
            $order = [
                'order_type' => 'boosting',
                'date' => now(),
                'cro' => auth()->user()->id,
                'old_new' => 'new',
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'boosting',
                'work_status' => 'pending',
                'package_amt' => $request->package_amt,
                'service' => $request->service,
                'tax' => $request->tax,
                'payment_status' => $request->payment_statusb,
                'cash' => $request->cashb,
                'advance' => $request->advanceb,
                'amount' => $request->amountb,
                'page' => $request->pageb,
                'details' => $request->detailsb,
            ];
            $inv = InvoiceId::create([
                'date' => today(),
            ]);
            $inv_id = $inv->id;
            return view('call_center.invoice-solo', compact('order', 'inv_id'));
        }
        // Scenario 2: Only order_type2 is checked
        elseif (!$orderType1 && $orderType2 && !$orderType3) {
            $order = [
                'order_type' => 'designs',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'design',
                'work_status' => 'pending',
                'payment_status' => $request->payment_statusa,
                'cash' => $request->casha,
                'advance' => $request->advancea,
                'amount' => $request->amounta,
            ];
            $inv = InvoiceId::create([
                'date' => today(),
            ]);
            $inv_id = $inv->id;
            return view('call_center.invoice-solo', compact('order', 'inv_id'));
        }
        // Scenario 3: Only order_type3 is checked
        elseif (!$orderType1 && !$orderType2 && $orderType3) {
            $order = [
                'order_type' => 'video',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'video',
                'work_status' => 'pending',
                'payment_status' => $request->payment_statusv,
                'cash' => $request->cashv,
                'advance' => $request->advancev,
                'amount' => $request->amountv,
                'our_amount' => $request->our_amountv,
                'script' => $request->scriptv,
                'shoot' => 'pending',
            ];
            $inv = InvoiceId::create([
                'date' => today(),
            ]);
            $inv_id = $inv->id;
            return view('call_center.invoice-solo', compact('order', 'inv_id'));
        }
        // Scenario 4: order_type1 and order_type2 are checked
        elseif ($orderType1 && $orderType2 && !$orderType3) {
            $order1 = [
                'order_type' => 'boosting',
                'date' => now(),
                'cro' => auth()->user()->id,
                'old_new' => 'new',
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'boosting',
                'work_status' => 'pending',
                'package_amt' => $request->package_amt,
                'service' => $request->service,
                'tax' => $request->tax,
                'payment_status' => $request->payment_statusb,
                'cash' => $request->cashb,
                'advance' => $request->advanceb,
                'amount' => $request->amountb,
                'page' => $request->pageb,
                'details' => $request->detailsb,
            ];

            $order2 = [
                'order_type' => 'designs',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'design',
                'work_status' => 'pending',
                'payment_status' => $request->payment_statusa,
                'cash' => $request->casha,
                'advance' => $request->advancea,
                'amount' => $request->amounta,
            ];
            $inv = InvoiceId::create([
                'date' => today(),
            ]);
            $inv_id = $inv->id;
            return view('call_center.invoice-two', compact('order1', 'order2', 'inv_id'));
        }
        // Scenario 5: order_type1 and order_type3 are checked
        elseif ($orderType1 && !$orderType2 && $orderType3) {
            $order1 = [
                'order_type' => 'boosting',
                'date' => now(),
                'cro' => auth()->user()->id,
                'old_new' => 'new',
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'boosting',
                'work_status' => 'pending',
                'package_amt' => $request->package_amt,
                'service' => $request->service,
                'tax' => $request->tax,
                'payment_status' => $request->payment_statusb,
                'cash' => $request->cashb,
                'advance' => $request->advanceb,
                'amount' => $request->amountb,
                'page' => $request->pageb,
                'details' => $request->detailsb,
            ];

            $order2 = [
                'order_type' => 'video',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'video',
                'work_status' => 'pending',
                'payment_status' => $request->payment_statusv,
                'cash' => $request->cashv,
                'advance' => $request->advancev,
                'amount' => $request->amountv,
                'our_amount' => $request->our_amountv,
                'script' => $request->scriptv,
                'shoot' => 'pending',
            ];

            $inv = InvoiceId::create([
                'date' => today(),
            ]);
            $inv_id = $inv->id;
            return view('call_center.invoice-two', compact('order1', 'order2', 'inv_id'));
        }
        // Scenario 6: order_type2 and order_type3 are checked
        elseif (!$orderType1 && $orderType2 && $orderType3) {

            $order1 = [
                'order_type' => 'designs',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'design',
                'work_status' => 'pending',
                'payment_status' => $request->payment_statusa,
                'cash' => $request->casha,
                'advance' => $request->advancea,
                'amount' => $request->amounta,
            ];

            $order2 = [
                'order_type' => 'video',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'video',
                'work_status' => 'pending',
                'payment_status' => $request->payment_statusv,
                'cash' => $request->cashv,
                'advance' => $request->advancev,
                'amount' => $request->amountv,
                'our_amount' => $request->our_amountv,
                'script' => $request->scriptv,
                'shoot' => 'pending',
            ];
            $inv = InvoiceId::create([
                'date' => today(),
            ]);
            $inv_id = $inv->id;

            return view('call_center.invoice-two', compact('order1', 'order2', 'inv_id'));
        }
        // Scenario 7: All three order types are checked
        elseif ($orderType1 && $orderType2 && $orderType3) {

            $order1 = [
                'order_type' => 'boosting',
                'date' => now(),
                'cro' => auth()->user()->id,
                'old_new' => 'new',
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'boosting',
                'work_status' => 'pending',
                'package_amt' => $request->package_amt,
                'service' => $request->service,
                'tax' => $request->tax,
                'payment_status' => $request->payment_statusb,
                'cash' => $request->cashb,
                'advance' => $request->advanceb,
                'amount' => $request->amountb,
                'page' => $request->pageb,
                'details' => $request->detailsb,
            ];

            $order2 = [
                'order_type' => 'designs',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'design',
                'work_status' => 'pending',
                'payment_status' => $request->payment_statusa,
                'cash' => $request->casha,
                'advance' => $request->advancea,
                'amount' => $request->amounta,
            ];

            $order3 = [
                'order_type' => 'video',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => 'video',
                'work_status' => 'pending',
                'payment_status' => $request->payment_statusv,
                'cash' => $request->cashv,
                'advance' => $request->advancev,
                'amount' => $request->amountv,
                'our_amount' => $request->our_amountv,
                'script' => $request->scriptv,
                'shoot' => 'pending',
            ];
            $inv = InvoiceId::create([
                'date' => today(),
            ]);
            $inv_id = $inv->id;
            return view('call_center.invoice-all', compact('order1', 'order2', 'order3', 'inv_id'));
        }

        return redirect()->back()->with('error', 'No order type selected.');
    }

}