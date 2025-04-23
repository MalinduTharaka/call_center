<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceId;
use App\Models\WorkType;
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
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        return view('call_center.invoice-solo', compact('order', 'invoices', 'work_types'));
    }

    public function invoicetwo($id1, $id2){
        $order1 = Order::findOrFail($id1);
        $order2 = Order::findOrFail($id2);
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        return view('call_center.invoice-two', compact('order1', 'order2', 'invoices', 'work_types'));
    }

    public function invoiceall($id1, $id2, $id3){
        $order1 = Order::findOrFail($id1);
        $order2 = Order::findOrFail($id2);
        $order3 = Order::findOrFail($id3);
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        return view('call_center.invoice-all', compact('order1', 'order2', 'order3', 'invoices', 'work_types'));
    }

    public function new_invoice(Request $request)
    {
        // Determine selected order types
        $selectedTypes = [];
        if ($request->has('order_type1'))
            $selectedTypes[] = 'boosting';
        if ($request->has('order_type2'))
            $selectedTypes[] = 'designs';
        if ($request->has('order_type3'))
            $selectedTypes[] = 'video';

        if (empty($selectedTypes)) {
            return redirect()->back()->with('error', 'No order type selected.');
        }

        // Collect entries for each selected type
        $boostingEntries = $request->input('boosting', []);
        $designEntries = $request->input('design', []);
        $videoEntries = $request->input('video', []);

        // Prepare order data arrays
        $boostingOrders = [];
        $designOrders = [];
        $videoOrders = [];

        foreach ($boostingEntries as $entry) {
            $boostingOrders[] = [
                'order_type' => 'boosting',
                'date' => now(),
                'cro' => auth()->user()->id,
                'old_new' => 'new',
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => $entry['work_type'] ?? '',
                'package_amt' => $entry['package_amt'] ?? 0,
                'service' => $entry['service'] ?? '',
                'tax' => $entry['tax'] ?? 0,
            ];
        }

        foreach ($designEntries as $entry) {
            $designOrders[] = [
                'order_type' => 'designs',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => $entry['work_type'] ?? '',
                'amount' => $entry['amount'] ?? 0,
            ];
        }

        foreach ($videoEntries as $entry) {
            $videoOrders[] = [
                'order_type' => 'video',
                'date' => now(),
                'cro' => auth()->user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'work_type' => $entry['style'] ?? '',
                'amount' => $entry['amount'] ?? 0,
                'time' => $entry['time'] ?? 0,
            ];
        }

        // Create invoice ID
        $inv = InvoiceId::create(['date' => today()]);
        $inv_id = $inv->id;

        $work_types = WorkType::all();
        // Prepare data for view
        $data = [
            'inv_id' => $inv_id,
            'invoices' => Invoice::all(),
            'boostingOrders' => $boostingOrders,
            'designOrders' => $designOrders,
            'videoOrders' => $videoOrders,
            'work_types' => $work_types,
            'type' => $request->type,
        ];

        

        // Determine which view to render based on selected types count
        $view = match (count($selectedTypes)) {
            1 => 'invoice-solo',
            2 => 'invoice-two',
            default => 'invoice-all',
        };

        return view("call_center.$view", $data);
    }


    public function markAsRead(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);

        if ($invoice) {
            $invoice->notifi_status = 'read';
            $invoice->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}