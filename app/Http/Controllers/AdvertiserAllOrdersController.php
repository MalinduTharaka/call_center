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

class AdvertiserAllOrdersController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::where('ps', '1')->where('order_type', 'boosting')->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->get();
        $packages = Package::all();
        $users = User::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('advertiser.advertiser-all-orders', compact('orders', 'packages', 'users', 'invoices', 'work_types', 'video_pkgs'));
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

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::where('ps', '1')->where('order_type', 'boosting')->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->get();
        $users = User::all();

        // This returns only the rows markup
        return view('advertiser.all-order-body', compact(
            'orders',
            'users',
        ));
    }


}
