<?php

namespace App\Http\Controllers;

use App\Models\OtherOrder;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RefundOrder;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{


    public function indexOrders()
    {
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $orders = RefundOrder::whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();
        $users = User::all();
        $invoices = Invoice::all();
        return view('admin.admin-refund-orders', compact('orders', 'users', 'invoices'));
    }

    public function indexOR(){
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $invoices = Invoice::all();
        $other_orders = RefundOrder::whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();
        $users = User::all();
        return view('admin.admin-refundOR', compact('other_orders',  'users', 'invoices'));
    }

    public function refundOrders(Request $request)
    {
        // 1) Validate input
        $data = $request->validate([
            'inv'    => ['required', 'exists:invoices,inv'],
            'orders' => ['required', 'array'],
            'orders.*.order_id' => ['required', 'integer', 'exists:orders,id'],
            'orders.*.reason'   => ['required', 'string', 'max:255'],
        ]);

        // 2) Load the Invoice model
        $invoice = Invoice::where('inv', $data['inv'])->firstOrFail();

        DB::transaction(function() use ($data, $invoice) {
            foreach ($data['orders'] as $orderData) {
                $orderId = $orderData['order_id'];
                $reason  = $orderData['reason'];

                // 3) Fetch the Order
                /** @var Order $order */
                $order = Order::findOrFail($orderId);

                // Capture amounts *before* zeroing
                $oldPkgAmt  = $order->package_amt;
                $oldService = $order->service;
                $oldTax     = $order->tax;
                $oldAmount  = $order->amount;
                $oldAdvance = $order->advance;

                // 4) Build the refund payload
                $refundPayload = [
                    'order_id'    => $order->id,
                    'invoice_id'  => $order->invoice_id,
                    'date'        => Carbon::now(),
                    'name'        => $order->name,
                    'cro'         => $order->uid,
                    'contact'     => $order->contact,
                    'order_type'  => $order->order_type,
                    'work_type'   => $order->work_type_id,
                    'reason'      => $reason,
                    // pkg_amt, service, tax, amount or advance depending on payment_status
                    'pkg_amt'     => 0,
                    'service'     => 0,
                    'tax'         => 0,
                    'amount'      => 0,
                    'advance'     => 0,
                ];

                if ($order->payment_status === 'done') {
                    // include all except advance
                    $refundPayload['pkg_amt'] = $oldPkgAmt;
                    $refundPayload['service'] = $oldService;
                    $refundPayload['tax']     = $oldTax;
                    $refundPayload['amount']  = $oldAmount;
                } else {
                    // only advance
                    $refundPayload['advance'] = $oldAdvance;
                }

                // 5) Insert into refund_orders
                RefundOrder::create($refundPayload);

                // 6) Zero out fields on the original Order
                //    and set ps = '0' and invoice = inv
                $updateData = [
                    'ps'      => '0',
                ];

                switch ($order->order_type) {
                    case 'boosting':
                        $updateData = array_merge($updateData, [
                            'package_amt' => 0,
                            'service'     => 0,
                            'tax'         => 0,
                            'advance'     => 0,
                        ]);
                        break;

                    case 'designs':
                    case 'video':
                        $updateData = array_merge($updateData, [
                            'amount'  => 0,
                            'advance' => 0,
                        ]);
                        break;
                }

                $order->update($updateData);
            }
        });

        return redirect()
            ->back()
            ->with('success', 'Refund processed successfully.');
    }
    public function refundOtherOrders(Request $request)
    {
        // Validate presence of invoice and orders array
        $data = $request->validate([
            'inv'    => 'required|string|exists:invoices,inv',
            'orders' => 'required|array',
            'orders.*.order_id' => 'required|integer|exists:other_orders,id',
            'orders.*.reason'   => 'nullable|string',
        ]);

        $invoiceNumber = $data['inv'];
        $ordersInput   = $data['orders'];

        // Fetch invoice once
        $invoice = Invoice::where('inv', $invoiceNumber)->first();

        DB::transaction(function () use ($ordersInput, $invoiceNumber, $invoice) {
            foreach ($ordersInput as $orderData) {
                $orderId = $orderData['order_id'];
                $reason  = $orderData['reason'] ?? '';

                // 1) Load the OtherOrder
                $other = OtherOrder::findOrFail($orderId);

                // Keep originals before zeroing
                $origAmount  = $other->amount;
                $origAdvance = $other->advance;
                $paymentStatus = $other->payment_status;

                // 2) Create a RefundOrder record
                $refund = new RefundOrder([
                    'order_id'   => $orderId,
                    'invoice_id' => $invoiceNumber,
                    'date'       => now(),
                    'name'       => $other->name,      // or $invoice->customer_name
                    'cro'        => $other->cro ?? auth()->id(),
                    'contact'    => $other->contact,   // or $invoice->contact
                    'work_type'  => $other->work_type,
                    'reason'     => $reason,
                    // Copy any billing components from the Invoice model:
                    'pkg_amt'    => $invoice->pkg_amt,
                    'service'    => $invoice->service_charge,
                    'tax'        => $invoice->tax_amount,
                ]);

                // 3) Only one of amount/advance, based on payment_status
                if (strtolower($paymentStatus) === 'done') {
                    $refund->amount  = $origAmount;
                    $refund->advance = 0;
                } else {
                    $refund->amount  = 0;
                    $refund->advance = $origAdvance;
                }

                $refund->save();

                // 4) Zero out the OtherOrder and set ps = '0'
                $other->amount     = 0;
                $other->advance    = 0;
                $other->ps         = '0';
                $other->invoice_id = $invoiceNumber;
                $other->save();
            }
        });

        return redirect()->back()
                         ->with('success', 'Refund(s) processed successfully.');
    }

}
