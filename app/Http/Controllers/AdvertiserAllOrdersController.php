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

        $orders = Order::whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->get();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('advertiser.advertiser-all-orders', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types', 'video_pkgs'));
    }

    public function updateAdvAll(Request $request, $id)
    {
       
        $advertiser = Order::findOrFail($id);

        // Validate advertiser_id if necessary
        $request->validate([
            'advertiser_id' => 'required|exists:users,id',
        ]);

        // Only update advertiser_id and set work_status manually
        $advertiser->update([
            'advertiser_id' => $request->input('advertiser_id'),
            'work_status' => 'advertise pending',
        ]);

        return redirect()->back()->with('success', 'Add Updated Successfully');
    }
}
