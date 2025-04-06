<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkType;

class WorkTypeController extends Controller
{
    public function index()
    {
        $worktypes = WorkType::all();
        return view('admin.work-type', compact('worktypes'));
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

        WorkType::create($request->all());

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
