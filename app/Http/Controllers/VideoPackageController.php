<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\TimeSlot;
use App\Models\VideoPkg;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoPackageController extends Controller
{
    public function index()
    {
        $timeSlots = TimeSlot::all();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $packages = VideoPkg::all();
        return view('video.video-package', compact('packages','invoices','timeSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'time' => 'required|string',
            'type' => 'required|string',
        ]);

        VideoPkg::create($request->only('amount', 'time', 'type'));
        return redirect()->back()->with('success', 'Package created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'time' => 'required|string',
            'type' => 'required|string',
        ]);

        $pkg = VideoPkg::findOrFail($id);
        $pkg->update($request->only('amount', 'time', 'type'));

        return redirect()->back()->with('success', 'Package updated successfully.');
    }

    public function destroy($id)
    {
        $pkg = VideoPkg::findOrFail($id);
        $pkg->delete();

        return redirect()->back()->with('success', 'Package deleted successfully.');
    }
}
