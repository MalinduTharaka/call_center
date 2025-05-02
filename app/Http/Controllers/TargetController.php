<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        $targets = Target::all();
        return view('call_center.target', compact('targets','invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target' => 'required|numeric',
            'user_role' => 'required|string',
            'target_type' => 'required|string',
            'target_category' => 'required|string',
        ]);

        Target::create($request->all());
        return redirect()->route('target.index')->with('success', 'Target created successfully.');
    }

    public function update(Request $request, Target $target)
    {
        $request->validate([
            'target' => 'required|numeric',
            'user_role' => 'required|string',
            'target_type' => 'required|string',
            'target_category' => 'required|string',
        ]);

        $target->update($request->all());
        return redirect()->route('target.index')->with('success', 'Target updated successfully.');
    }

    public function destroy(Target $target)
    {
        $target->delete();
        return redirect()->route('target.index')->with('success', 'Target deleted successfully.');
    }
}
