<?php

namespace App\Http\Controllers;

use App\Models\EditorsWork;
use App\Models\Invoice;
use App\Models\User;
use App\Models\WorkType;
use Illuminate\Http\Request;

class VideoEditorsWorkDoneController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        $entries = EditorsWork::with('user')->latest()->get();
        $users   = User::all();
        $workTypes = WorkType::where('order_type', 'video')->get();
        return view('call_center.video-editors-work-done', compact('entries', 'users','invoices','workTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'work_type' => 'required|string',
            'duration'  => 'required|string',
            'amount'    => 'required|numeric',
            'date'      => 'required|date',
        ]);

        EditorsWork::create($request->all());

        return back()->with('success', 'Work entry created successfully.');
    }

    public function update(Request $request, EditorsWork $editorsWork)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'work_type' => 'required|string',
            'duration'  => 'required|string',
            'amount'    => 'required|numeric',
            'date'      => 'required|date',
        ]);

        $editorsWork->update($request->all());

        return back()->with('success', 'Work entry updated successfully.');
    }

    public function destroy(EditorsWork $editorsWork)
    {
        $editorsWork->delete();

        return back()->with('success', 'Work entry deleted successfully.');
    }
}