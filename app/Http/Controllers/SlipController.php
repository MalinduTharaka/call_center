<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slip;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class SlipController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the file in storage/app/public/slips
        $path = $request->file('slip')->store('slips', 'public');

        // Save slip record in database
        $slip = new Slip();
        $slip->order_id = $order->id;
        $slip->slip_path = $path;
        $slip->save();

        return back()->with('success', 'Slip uploaded successfully!');
    }
}
