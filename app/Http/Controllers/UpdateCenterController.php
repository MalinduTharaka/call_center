<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Illuminate\Http\Request;

class UpdateCenterController extends Controller
{
    public function index(){
        $orders = Order::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('update_center.update-center', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types', 'video_pkgs'));
    }
}
