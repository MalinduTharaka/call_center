<?php

namespace App\Http\Controllers;

use App\Models\AdvertiserWork;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdvertiserWorkController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        $works = AdvertiserWork::with('user')->latest()->get(); // Eager load user if needed
        return view('call_center.advertisors-work-done', compact('works','invoices'));
    }

    public function update(Request $request, AdvertiserWork $advertiserWork)
    {
        $request->validate([
            'add_count' => 'required|integer',
            'wte_add_count' => 'nullable|integer',
            'target' => 'nullable|integer',
            'complete_time' => 'nullable',
            'off_time' => 'nullable',
            'ot' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $advertiserWork->update($request->all());

        return redirect()->route('advertiser-works.index')->with('success', 'Work record updated successfully.');
    }
}
