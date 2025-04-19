<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Slip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlipController extends Controller
{
    public function store(Request $request)
    {
        // 1) Validate incoming request
        $request->validate([
            'slip'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'inv'           => 'required|exists:orders,invoice',
            'bank'          => 'required|string',
            'payment_type'  => 'required|in:completed,partial',
            'advanceb'      => 'nullable|array',
            'advanceb.*'    => 'nullable|numeric|min:0',
            'advanced'      => 'nullable|array',
            'advanced.*'    => 'nullable|numeric|min:0',
            'advancev'      => 'nullable|array',
            'advancev.*'    => 'nullable|numeric|min:0',
            'due_date'      => 'required_if:payment_type,partial|integer|min:1|max:365',
        ]);

        // 2) Ensure the invoice exists in orders
        $order = Order::where('invoice', $request->inv)->first();
        if (! $order) {
            return back()->with('error', 'Invoice not found in the order records.');
        }

        // 3) Handle slip upload
        if (! $request->hasFile('slip') || ! $request->file('slip')->isValid()) {
            return back()->with('error', 'File upload failed or no file provided.');
        }

        $path = $request->file('slip')->store('slips', 'public');
        $slip = Slip::create([
            'order_id'  => $request->inv,
            'slip_path' => $path,
            'bank'      => $request->bank,
        ]);

        // 4) Completed payment path
        if ($request->payment_type === 'completed') {
            Order::where('invoice', $request->inv)
                 ->update(['payment_status' => 'done', 'advance' => 0]);

            Invoice::where('inv', $request->inv)
                   ->firstOrFail()
                   ->update(['status' => 'paid']);

            return back()->with('success', 'Payment slip uploaded and marked complete.')->with('slip_path', $path);
        }

        // 5) Partial payment path
        // Sum each advance-array (safely defaulting to empty array)
        $advanceb = collect($request->advanceb ?? [])->filter()->sum();
        $advanced = collect($request->advanced ?? [])->filter()->sum();
        $advancev = collect($request->advancev ?? [])->filter()->sum();

        $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
        $totalAdvance = $advanceb + $advanced + $advancev;

        // Distribute into amt1, amt2, amt3 slots
        if (! $invoice->amt1) {
            $invoice->amt1 = $totalAdvance;
        } elseif (! $invoice->amt2) {
            $invoice->amt2 = $totalAdvance;
        } elseif (! $invoice->amt3) {
            $invoice->amt3 = $totalAdvance;
        }
        // Update due_date on invoice
        $invoice->due_date = Carbon::today()->addDays((int)$request->due_date);
        $invoice->save();

        // Fetch all related orders
        $orders       = Order::where('invoice', $request->inv)->get();
        $totalOrders  = $orders->count();
        $boostingCnt  = $orders->where('order_type', 'boosting')->count();
        $designsCnt   = $orders->where('order_type', 'designs')->count();
        $videoCnt     = $orders->where('order_type', 'video')->count();

        // Helper to assign advance to a subset of orders
        $assignAdvance = function($subset, $amountPerOrder) {
            foreach ($subset as $o) {
                $o->advance        = $amountPerOrder;
                $o->payment_status = 'partial';
                $o->save();
            }
        };

        // CASE A: Only one type provided → split evenly across ALL orders
        if (($advanceb   && ! $advanced && ! $advancev)
         || (! $advanceb  && $advanced  && ! $advancev)
         || (! $advanceb  && ! $advanced && $advancev)
        ) {
            $perOrder = $totalAdvance / max($totalOrders, 1);
            foreach ($orders as $o) {
                $o->advance        = $perOrder;
                $o->payment_status = 'partial';
                $o->save();
            }
        }
        // CASE B: Exactly two types provided
        elseif (($advanceb && $advanced  && ! $advancev)
             || ($advanceb && ! $advanced && $advancev)
             || (! $advanceb && $advanced  && $advancev)
        ) {
            // Boosting + Designs
            if ($advanceb && $advanced) {
                if ($boostingCnt > 0) {
                    $assignAdvance(
                        $orders->where('order_type', 'boosting'),
                        $advanceb / $boostingCnt
                    );
                }
                if ($designsCnt > 0) {
                    $assignAdvance(
                        $orders->where('order_type', 'designs'),
                        $advanced / $designsCnt
                    );
                }
            }

            // Boosting + Video
            if ($advanceb && $advancev) {
                if ($boostingCnt > 0) {
                    $assignAdvance(
                        $orders->where('order_type', 'boosting'),
                        $advanceb / $boostingCnt
                    );
                }
                if ($videoCnt > 0) {
                    $assignAdvance(
                        $orders->where('order_type', 'video'),
                        $advancev / $videoCnt
                    );
                }
            }

            // Designs + Video
            if ($advanced && $advancev) {
                if ($designsCnt > 0) {
                    $assignAdvance(
                        $orders->where('order_type', 'designs'),
                        $advanced / $designsCnt
                    );
                }
                if ($videoCnt > 0) {
                    $assignAdvance(
                        $orders->where('order_type', 'video'),
                        $advancev / $videoCnt
                    );
                }
            }
        }
        // CASE C: All three types provided
        elseif ($advanceb && $advanced && $advancev) {
            if ($boostingCnt > 0) {
                $assignAdvance(
                    $orders->where('order_type', 'boosting'),
                    $advanceb / $boostingCnt
                );
            }
            if ($designsCnt > 0) {
                $assignAdvance(
                    $orders->where('order_type', 'designs'),
                    $advanced / $designsCnt
                );
            }
            if ($videoCnt > 0) {
                $assignAdvance(
                    $orders->where('order_type', 'video'),
                    $advancev / $videoCnt
                );
            }
        }

        return back()->with('success', 'Partial payment slip uploaded successfully.')->with('slip_path', $path);
    }
}
