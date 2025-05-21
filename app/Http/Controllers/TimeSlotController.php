<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $timeSlots = TimeSlot::latest()->get();
        return view('video.time-slots', compact('timeSlots','invoices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'time_value' => 'required|integer|min:1',
            'time_unit' => 'required|in:m,s,h'
        ]);

        TimeSlot::create($validated);
        return redirect()->back()->with('success', 'Time slot created successfully');
    }

    public function update(Request $request, TimeSlot $timeSlot)
    {
        $validated = $request->validate([
            'time_value' => 'required|integer|min:1',
            'time_unit' => 'required|in:m,s,h'
        ]);

        $timeSlot->update($validated);
        return redirect()->back()->with('success', 'Time slot updated successfully');
    }

    public function destroy(TimeSlot $timeSlot)
    {
        $timeSlot->delete();
        return redirect()->back()->with('success', 'Time slot deleted successfully');
    }
}

