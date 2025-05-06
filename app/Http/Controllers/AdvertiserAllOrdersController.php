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
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::where('ps', '1')->where('order_type','boosting')->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->get();
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

        $request->validate([
            'advertiser_id' => 'required|exists:users,id',
        ]);

        $order->update([
            'advertiser_id' => $request->input('advertiser_id'),
            'work_status' => 'advertise pending',
        ]);

        $order->load('advertiser');

        return response()->json(['success' => true,'order' => $order,]);
    }


}
