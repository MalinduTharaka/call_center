<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OtherOrder;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(){
        $orders = Order::where('ps', '1')->get();
        $other_orders = OtherOrder::where('ps', '1')->get();
    }
}
