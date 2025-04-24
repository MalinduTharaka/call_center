<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        $orders = Order::all();
        $other_orders = OtherOrder::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('profile.user-profile', compact('orders', 'other_orders', 'packages', 'users', 'slips', 'invoices', 'work_types', 'video_pkgs'));
    }
}
