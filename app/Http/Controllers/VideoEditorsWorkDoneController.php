<?php

namespace App\Http\Controllers;

use App\Models\EditorsWork;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Models\WorkType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoEditorsWorkDoneController extends Controller
{
    public function index(Request $request)
    {
        // Base query: eager‑load both user & order
        $query = EditorsWork::with(['user', 'Order']);

        // 1. Month‑Year (HTML5 “month” input)
        if ($request->filled('month_year')) {
            [$year, $month] = explode('-', $request->month_year);
            $query->whereYear('date', $year)
                  ->whereMonth('date', $month);
        }

        // 2. Exact Date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // 4. User
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // 5. Work Status (also on the Order model)
        if ($request->filled('work_status')) {
            $query->whereHas('Order', function($q) use ($request) {
                $q->where('work_status', $request->work_status);
            });
        }

        // Pull only as many as you need, or paginate
        $entries = $query->latest()->get();

        // Lists for the <select>s
        $clients     = Order::select('id','name')->orderBy('name')->get();
        $users       = User::orderBy('name')->get();
        $workTypes   = WorkType::where('order_type','video')->get();
        $statuses    = Order::select('work_status')->distinct()->pluck('work_status');
        $invoices = Invoice::where('due_date', Carbon::today())->get();

        // Pass along the `Request` so old inputs can be re‑populated
        return view('call_center.video-editors-work-done', compact(
            'entries','clients','users','workTypes','statuses','request', 'invoices'
        ));
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
        $editorsWork->update($request->all());

        return back()->with('success', 'Work entry updated successfully.');
    }

    public function destroy(EditorsWork $editorsWork)
    {
        $editorsWork->delete();

        return back()->with('success', 'Work entry deleted successfully.');
    }
}