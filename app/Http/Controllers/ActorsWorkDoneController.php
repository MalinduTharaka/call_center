<?php

namespace App\Http\Controllers;

use App\Models\ActorsWork;
use App\Models\Invoice;
use App\Models\User;
use App\Models\WorkType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActorsWorkDoneController extends Controller
{
    public function index(Request $request)
    {
        // keep your existing variables
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $users     = User::all();
        $workTypes = WorkType::where('order_type', 'video')->get();

        // base query: eager‑load user, order by latest
        $query = ActorsWork::with('user')->latest();

        // 1) Month‑Year filter on created_at (YYYY‑MM)
        if ($request->filled('month_year')) {
            [$year, $month] = explode('-', $request->month_year);
            $query->whereYear('date', $year)
                  ->whereMonth('date', $month);
        }

        // 2) Exact date filter on your `date` column
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // 3) User filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // 4) Work Type filter
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        // finally get the entries
        $entries = $query->get();

        return view(
            'call_center.actors-work-done',
            compact('entries', 'users', 'invoices', 'workTypes', 'request')
        );
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