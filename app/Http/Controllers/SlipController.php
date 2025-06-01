<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use App\Models\Slip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Nullable;

class SlipController extends Controller
{
    public function store(Request $request)
{
    // 1) Validate incoming request
    $request->validate([
        'slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'inv' => 'required|exists:orders,invoice',
        'bank' => 'required|string',
        'payment_type' => 'required|in:completed,partial',
        'advanceb' => 'nullable|array',
        'advanceb.*' => 'nullable|numeric|min:0',
        'advanced' => 'nullable|array',
        'advanced.*' => 'nullable|numeric|min:0',
        'advancev' => 'nullable|array',
        'advancev.*' => 'nullable|numeric|min:0',
        'due_date' => 'required_if:payment_type,partial|integer|min:1|max:365',
    ]);

    // 2) Ensure the invoice exists in orders
    $order = Order::where('invoice', $request->inv)->firstOrFail();

    // 3) Handle slip upload into public/slips
    if (!$request->hasFile('slip') || !$request->file('slip')->isValid()) {
        return back()->with('error', 'File upload failed or no file provided.');
    }

    $file = $request->file('slip');
    $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

    $destination = public_path('slips');
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }

    $file->move($destination, $filename);
    $path = 'slips/' . $filename;

    $slip = Slip::create([
        'order_id' => $request->inv,
        'slip_path' => $path,
        'bank' => $request->bank,
    ]);

    // 4) Completed payment path
    if ($request->payment_type === 'completed') {
        Order::where('invoice', $request->inv)
            ->update(['payment_status' => 'done', 'advance' => 0, 'ps' => '1', 'created_at' => Carbon::now()]);

        $tv = Invoice::where('inv', $request->inv)->sum('total');

        Invoice::where('inv', $request->inv)
            ->firstOrFail()
            ->update(['status' => 'paid', 'amt1' => $tv, 'amt2' => null, 'amt3' => null]);

        return back()
            ->with('success', 'Payment slip uploaded and marked complete.')
            ->with('slip_path', $path);
    }

    // 5) Partial payment path
    $advanceb = collect($request->advanceb ?? [])->filter()->sum();
    $advanced = collect($request->advanced ?? [])->filter()->sum();
    $advancev = collect($request->advancev ?? [])->filter()->sum();
    $totalAdvance = $advanceb + $advanced + $advancev;

    $invoice = Invoice::where('inv', $request->inv)->firstOrFail();

    if (!$invoice->amt1) {
        $invoice->amt1 = $totalAdvance;
    } elseif (!$invoice->amt2) {
        $invoice->amt2 = $totalAdvance;
    } elseif (!$invoice->amt3) {
        $invoice->amt3 = $totalAdvance;
    }

    $invoice->due_date = Carbon::today()->addDays((int) $request->due_date);
    $invoice->save();

    Order::where('invoice', $request->inv)->update(['ps' => '1']);

    // Assign advances directly as entered
    $orders = Order::where('invoice', $request->inv)->get();

    $boostOrders = $orders->where('order_type', 'boosting')->values();
    $designOrders = $orders->where('order_type', 'designs')->values();
    $videoOrders  = $orders->where('order_type', 'video')->values();

    $now = Carbon::now();

    foreach ($boostOrders as $i => $order) {
        if (isset($request->advanceb[$i])) {
            $order->advance = $request->advanceb[$i];
            $order->payment_status = 'partial';
            $order->created_at = $now;
            $order->save();
        }
    }

    foreach ($designOrders as $i => $order) {
        if (isset($request->advanced[$i])) {
            $order->advance = $request->advanced[$i];
            $order->payment_status = 'partial';
            $order->created_at = $now;
            $order->save();
        }
    }

    foreach ($videoOrders as $i => $order) {
        if (isset($request->advancev[$i])) {
            $order->advance = $request->advancev[$i];
            $order->payment_status = 'partial';
            $order->created_at = $now;
            $order->save();
        }
    }

    return back()
        ->with('success', 'Partial payment slip uploaded successfully.')
        ->with('slip_path', $path);
}


    public function storeOR(Request $request)
    {
        // 1) Validate incoming request
        $request->validate([
            'slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'inv' => 'required|exists:invoices,inv',
            'bank' => 'required|string',
            'payment_type' => 'required|in:completed,partial',
            'advance' => 'nullable|array',
            'advance.*' => 'nullable|numeric|min:0',
            'due_date' => 'required_if:payment_type,partial|integer|min:1|max:365',
        ]);

        // 2) Ensure the invoice exists
        $invoice = Invoice::where('inv', $request->inv)->firstOrFail();

        // 3) Handle slip upload into public/slips
        if (!$request->hasFile('slip') || !$request->file('slip')->isValid()) {
            return back()->with('error', 'File upload failed or no file provided.');
        }

        $file = $request->file('slip');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Ensure the public/slips directory exists
        $destination = public_path('slips');
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        // Move the uploaded file
        $file->move($destination, $filename);

        // Build the public-relative path
        $path = 'slips/' . $filename;

        // Record the slip
        Slip::create([
            'order_id' => $request->inv,
            'slip_path' => $path,
            'bank' => $request->bank,
        ]);

        // 4) Completed payment path
        if ($request->payment_type === 'completed') {
            OtherOrder::where('invoice_id', $request->inv)
                ->update([
                    'payment_status' => 'done',
                    'advance' => 0,
                    'ps' => '1',
                    'created_at' => Carbon::now(),
                ]);

            $invoice->update([
                'status' => 'paid',
                'amt1' => $invoice->total,
                'amt2' => null,
                'amt3' => null,
            ]);

            return back()
                ->with('success', 'Payment slip uploaded and marked complete.')
                ->with('slip_path', $path);
        }

        // 5) Partial payment path
        $advances = collect($request->advance ?? [])->values();
        $sumAdvance = $advances->sum();

        // Assign next available amt slot on invoice
        if (!$invoice->amt1) {
            $invoice->amt1 = $sumAdvance;
        } elseif (!$invoice->amt2) {
            $invoice->amt2 = $sumAdvance;
        } else {
            $invoice->amt3 = $sumAdvance;
        }

        $invoice->due_date = Carbon::today()->addDays((int) $request->due_date);
        $invoice->save();

        // Mark all OtherOrders as in-process of payment slip
        OtherOrder::where('invoice_id', $request->inv)
            ->update(['ps' => '1']);

        // 6) Fetch and assign each advance value
        $orders = OtherOrder::where('invoice_id', $request->inv)
            ->orderBy('id')
            ->get();

        foreach ($orders as $index => $order) {
            $order->advance = $advances->get($index, 0);
            $order->payment_status = 'partial';
            $order->created_at = Carbon::now();
            $order->save();
        }

        return back()
            ->with('success', 'Partial payment slip uploaded successfully.')
            ->with('slip_path', $path);
    }

    public function deleteslp(Request $request)
    {
        // Validate that 'inv' is present
        $request->validate([
            'inv' => 'required|string|exists:invoices,inv',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Fetch the invoice (or throw 404)
            $invoice = Invoice::where('inv', $request->inv)->firstOrFail();

            // 2. Reset invoice fields
            $invoice->update([
                'status' => 'pending',
                'due_date' => null,
                'amt1' => null,
                'amt2' => null,
                'amt3' => null,
            ]);

            // 3. Reset all related orders in one query
            Order::where('invoice', $request->inv)
                ->update([
                    'payment_status' => null,
                    'cash' => null,
                    'advance' => null,
                    'ps' => '0',
                ]);

            // 4. Delete all related slips in one go
            Slip::where('order_id', $request->inv)->delete();
        });

        // 5. Return back with a success message (or whatever you prefer)
        return redirect()->back()
            ->with('success', "Invoice {$request->inv} has been reset and its slips deleted.");
    }


    public function deleteORslp(Request $request)
    {
        // Validate that 'inv' is present
        $request->validate([
            'inv' => 'required|string|exists:invoices,inv',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Fetch the invoice (or throw 404)
            $invoice = Invoice::where('inv', $request->inv)->firstOrFail();

            // 2. Reset invoice fields
            $invoice->update([
                'status' => 'pending',
                'due_date' => null,
                'amt1' => null,
                'amt2' => null,
                'amt3' => null,
            ]);

            // 3. Reset all related orders in one query
            OtherOrder::where('invoice_id', $request->inv)
                ->update([
                    'payment_status' => null,
                    'cash' => null,
                    'advance' => null,
                    'ps' => '0',
                ]);

            // 4. Delete all related slips in one go
            Slip::where('order_id', $request->inv)->delete();
        });

        // 5. Return back with a success message (or whatever you prefer)
        return redirect()->back()
            ->with('success', "Invoice {$request->inv} has been reset and its slips deleted.");
    }

    public function getSlips($invoice)
    {
        $slips = Slip::where('order_id', $invoice)->get();

        $formattedSlips = $slips->map(function ($slip) {
            return [
                'bank' => $slip->bank ?? 'N/A',
                'path' => asset($slip->slip_path),
                'type' => pathinfo($slip->slip_path, PATHINFO_EXTENSION)
            ];
        });

        return response()->json($formattedSlips);
    }
    public function getSlipsOR($invoice)
    {
        $slips = Slip::where('order_id', $invoice)->get();

        $formattedSlips = $slips->map(function ($slip) {
            return [
                'bank' => $slip->bank ?? 'N/A',
                'path' => asset($slip->slip_path),
                'type' => pathinfo($slip->slip_path, PATHINFO_EXTENSION)
            ];
        });

        return response()->json($formattedSlips);
    }
}
