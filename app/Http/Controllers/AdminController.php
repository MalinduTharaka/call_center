<?php

namespace App\Http\Controllers;

use App\Models\EditorsWork;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function indexo(){
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::whereBetween('date', [$from, $to])->orderBy('date')->get();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('admin.admin-orders', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types', 'video_pkgs'));
    }


    public function updateBoostingAD(Request $request, $id){
        $uc = Order::findOrFail($id);
        $uc->update($request->all());
        return redirect()->back()->with('success', 'Order Update Done');
    }

    public function updateDesignsAD(Request $request, $id){
        $uc = Order::findOrFail($id);
        $uc->update($request->all());
        return redirect()->back()->with('success', 'Order Update Done');
    }

    public function updateVideoAD(Request $request, $id){
        $uc = Order::findOrFail($id);
        $uc->update($request->all());
    
        return redirect()->back()->with('success', 'Order Update Done');
    }
    

    public function indexOR(){
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $invoices = Invoice::all();
        $other_orders = OtherOrder::whereBetween('date', [$from, $to])->orderBy('date')->get();
        $slips = Slip::all();
        $users = User::all();
        return view('admin.admin-ordersOR', compact('other_orders',  'users', 'slips', 'invoices'));
    }

    public function updateOrAD(Request $request, $id){
        $uc = OtherOrder::findOrFail($id);
        $uc->update($request->all());
    
        return redirect()->back()->with('success', 'Other Order Update Done');
    }
}
