<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Slip;


class OrderConroller extends Controller
{
    public function index(){
        $orders = Order::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        return view('call_center.orders', compact('orders', 'packages', 'users', 'slips'));
    }

    public function index1(){
        $orders = Order::all();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        return view('call_center.new-orders', compact('orders', 'packages', 'users', 'slips'));
    }
}
