<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceId;
use App\Models\OtherOrder;
use App\Models\Slip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OtherOrderController extends Controller
{

    public function index(){
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $invoices = Invoice::all();
        $other_orders = OtherOrder::whereBetween('date', [$from, $to])->get();
        $slips = Slip::all();
        $users = User::all();
        return view('call_center.other-orders', compact('other_orders',  'users', 'slips', 'invoices'));
    }

    public function otherInvoice(Request $request)
    {

        $invoices = Invoice::all();

        $inv = InvoiceId::create();
        $inv_id = $inv->id;

        // Basic data
        $name = $request->input('name');
        $contact = $request->input('contact');
        $type = $request->input('type'); // 0 = invoice, 1 = quotation

        // Multiple order items
        $orders = [];
        $workTypes = $request->input('work_type', []);
        $amounts = $request->input('amount', []);
        $notes = $request->input('note', []);

        foreach ($workTypes as $i => $workType) {
            $orders[] = [
                'work_type' => $workType,
                'amount' => $amounts[$i] ?? 0,
                'note' => $notes[$i] ?? '',
            ];
        }

        // Send all data to the view
        return view('call_center.invoice-other-order', [
            'name' => $name,
            'contact' => $contact,
            'type' => $type,
            'orders' => $orders,
            'inv_id' => $inv_id,
            'invoices' => $invoices,
        ]);
    }

    public function storeOI(Request $request){
        $data = $request->all();
    
        // Create invoice
        $invoice = Invoice::create([
            'user_id' => Auth::id(),
            'cc_num' => Auth::user()->cc_num,
            'date' => $request->date,
            'inv' => $data['inv_id'],
            'contact' => $data['contact'],
            'total' => $data['total'],
            'status' =>'pending',
            'type' => $data['type'],
        ]);
    
        // Create related orders
        foreach ($data['orders'] as $order) {
            OtherOrder::create([
                'date' => $request->date,
                'user_id' => Auth::id(),
                'cc_id' => Auth::user()->cc_num,
                'invoice_id' => $data['inv_id'], // foreign key
                'name' => $data['name'],
                'contact' => $data['contact'],
                'work_type' => $order['work_type'],
                'note' => $order['note'] ?? '',
                'amount' => $order['amount'],
            ]);
        }
        return redirect()->route('new.orders')->with('success', 'Invoice saved successfully.');
    }

    public function updateOI(Request $request, $id){
        $other_order = OtherOrder::findOrFail($id);
        $other_order->update($request->all());
        return redirect()->back()->with('success', 'Order Updated Successfully');
    }
}
