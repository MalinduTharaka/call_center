<?php

namespace App\Http\Controllers;

use App\Models\ActorsWork;
use App\Models\Invoice;
use App\Models\User;
use App\Models\WorkType;
use Illuminate\Http\Request;

class ActorsWorkDoneController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        $entries = ActorsWork::with('user')->latest()->get();
        $users   = User::all();
        $workTypes = WorkType::where('order_type', 'video')->get();
        return view('call_center.actors-work-done', compact('entries', 'users', 'invoices','workTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'work_type' => 'required|string',
            'note'      => 'required|string',
            'amount'    => 'required|numeric',
            'date'      => 'required|date',
        ]);

        ActorsWork::create($request->all());

        return back()->with('success', 'Actor work entry created successfully.');
    }

    public function update(Request $request, ActorsWork $actorsWork)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'work_type' => 'required|string',
            'note'      => 'required|string',
            'amount'    => 'required|numeric',
            'date'      => 'required|date',
        ]);

        $actorsWork->update($request->all());

        return back()->with('success', 'Actor work entry updated successfully.');
    }

    public function destroy(ActorsWork $actorsWork)
    {
        $actorsWork->delete();
        return back()->with('success', 'Actor work entry deleted successfully.');
    }
}