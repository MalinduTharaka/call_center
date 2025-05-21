<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdvertiserAllOrdersController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::where('ps', '1')->where('order_type', 'boosting')->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->get();
        $users = User::all();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $work_types = WorkType::all();
        return view('advertiser.advertiser-all-orders', compact('orders',  'users', 'invoices', 'work_types'));
    }


    public function updateAdvAll(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Merge JSON payload if needed
        if ($request->isJson()) {
            $request->merge($request->json()->all());
        }

        // Only advertiser_id is required
        $request->validate([
            'advertiser_id' => 'required|exists:users,id',
            // everything else is optional
            'work_status' => 'nullable|in:done,pending,send to customer,send to designer,error',
            'page' => 'nullable|in:new,our,existing',
            'details' => 'nullable|string|max:255',
            'add_acc_id' => 'nullable|url',
        ]);

        // --- NEW: if the request has *only* advertiser_id, 
        //     set work_status to "advertise pending" and exit
        $otherFields = ['work_status', 'page', 'details', 'add_acc_id'];
        $hasAnyOther = collect($otherFields)->contains(fn($f) => $request->filled($f));

        if (!$hasAnyOther) {
            $order->update([
                'advertiser_id' => $request->input('advertiser_id'),
                'work_status' => 'advertise pending'
            ]);
            $order->load('advertiser');

            return response()->json([
                'success' => true,
                'order' => $order,
            ]);
        }
        // --- END NEW

        // Build update array dynamically
        $data = ['advertiser_id' => $request->input('advertiser_id')];
        if ($request->filled('work_status')) {
            $data['work_status'] = $request->input('work_status');
        }
        if ($request->filled('page')) {
            $data['page'] = $request->input('page');
        }
        if ($request->filled('details')) {
            $data['details'] = $request->input('details');
        }
        if ($request->filled('add_acc_id')) {
            $data['add_acc_id'] = $request->input('add_acc_id');
        }

        $order->update($data);
        $order->load('advertiser');

        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
    }





    public function body()
    {
        $user = Auth::user();
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to = Carbon::parse($user->to_date)->endOfDay();

        $cacheKey = 'advertiser_orders_' . $user->id . '_' . $from->timestamp . '_' . $to->timestamp;

        $orders = Order::select([
                'id',
                'ce',
                'invoice',  
                'uid',
                'name',
                'old_new',
                'contact',
                'work_type_id',
                'page',
                'work_status',
                'payment_status',
                'cash',
                'advertiser_id',
                'package_amt',
                'service',
                'tax',
                'advance',
                'details',
                'add_acc_id',
                'created_at',
                'add_acc'
            ])
                ->whereBetween('created_at', [$from, $to])
                ->where('ps', '1')
                ->where('order_type', 'boosting')
                ->orderBy('created_at', 'desc')
                ->get();

        $users = User::all();
        return view('advertiser.all-order-body', compact('orders', 'users'));
    }


}
