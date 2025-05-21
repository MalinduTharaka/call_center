<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WorkType;

class WorkTypeController extends Controller
{
    public function index()
    {
        $worktypes = WorkType::all();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        return view('admin.work-type', compact('worktypes', 'invoices'));
    }


    public function create()
    {
        return view('admin.work-type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order_type' => 'required|string|max:255',
        ]);

        $workType = WorkType::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Work Type created successfully.',
                'data' => $workType,
            ]);
        }

        return redirect()->route('work-types.index')->with('success', 'Work Type created successfully.');
    }

    public function edit(WorkType $workType)
    {
        return view('admin.work-type.edit', compact('workType'));
    }

    public function update(Request $request, WorkType $workType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order_type' => 'required|string|max:255',
        ]);

        $workType->update($request->all());

        return redirect()->route('work-types.index')->with('success', 'Work Type updated successfully.');
    }

    public function destroy(WorkType $workType)
    {
        $workType->delete();

        return redirect()->route('work-types.index')->with('success', 'Work Type deleted successfully.');
    }
}
