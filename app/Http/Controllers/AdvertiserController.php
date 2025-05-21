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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertiserController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->get();
        $users = User::all();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('advertiser.advertiser', compact('orders', 'users', 'invoices', 'work_types', 'video_pkgs'));
    }

    public function updateAdv(Request $request, $id){
        $advertiser = Order::findOrFail($id);
        $advertiser->update($request->all());
        return redirect()->back()->with('success', 'Add Updated Successfully');
    }


    public function advertiserDesignView()
    {
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::whereBetween('created_at', [$from, $to])
        ->where('order_type', 'designs')
        ->where('ps', '1')
        ->orderBy('created_at', 'desc')->get();
        $users = User::all();
        $invoices = Invoice::all();
        return view('advertiser.advertiser-designs', compact('orders',  'users',  'invoices'));
    }
}
