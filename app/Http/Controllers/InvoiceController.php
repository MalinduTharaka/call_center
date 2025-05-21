<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceId;
use App\Models\WorkType;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function invoicesolo($id)
    {
        $user = Auth::user();
        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();
        $order = Order::findOrFail($id);
        $invoices = Invoice::whereBetween('date', [$from, $to])->get();
        $work_types = WorkType::all();
        return view('call_center.invoice-solo', compact('order', 'invoices', 'work_types'));
    }

    public function invoicetwo($id1, $id2)
    {
        $order1 = Order::findOrFail($id1);
        $order2 = Order::findOrFail($id2);
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        return view('call_center.invoice-two', compact('order1', 'order2', 'invoices', 'work_types'));
    }

    public function invoiceall($id1, $id2, $id3)
    {
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

    public function duplicate(Invoice $invoice)
    {
        // Retrieve all orders associated with the original invoice
        $originalOrders = Order::where('invoice', $invoice->inv)->get();

        // Create a new InvoiceId entry
        $newInvoiceId = InvoiceId::create([
            'date' => now(),
            'status' => 'duplicated', // Adjust the status as per your application's logic
        ]);

        // Generate the new invoice number with a 'DUP' prefix
        $newInv = 'dup' . $newInvoiceId->id;

        // Duplicate the original invoice
        $newInvoice = $invoice->replicate();
        $newInvoice->inv = $newInv;
        $newInvoice->date = now();

        // Exclude specified fields by setting them to null
        $excludedInvoiceFields = [
            'order_id1',
            'order_id2',
            'order_id3',
            'due_date',
            'notifi_status',
            'amt1',
            'amt2',
            'amt3'
        ];
        foreach ($excludedInvoiceFields as $field) {
            $newInvoice->$field = null;
        }

        $newInvoice->save();

        // Duplicate each associated order
        foreach ($originalOrders as $order) {
            $newOrder = $order->replicate();
            $newOrder->date = now();
            $newOrder->old_new = 'old';
            $newOrder->ps = '0';
            $newOrder->invoice = $newInv;

            // Exclude specified fields
            $excludedOrderFields = [
                'work_status',
                'payment_status',
                'cash',
                'advertiser_id',
                'advance',
                'details',
                'add_acc',
                'our_amount',
                'script',
                'shoot',
                'designer_id',
                'd_img',
                'due_date',
                'user_id',
                'add_acc_id',
                'fb_fee',
            ];
            foreach ($excludedOrderFields as $field) {
                $newOrder->$field = null;
            }

            $newOrder->save();
        }

        return redirect()->back()->with('success', 'Invoice duplicated successfully.');
    }
}