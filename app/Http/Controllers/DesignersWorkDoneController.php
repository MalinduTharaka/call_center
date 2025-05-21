<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\PostDesignersWork;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DesignersWorkDoneController extends Controller
{
    public function index(Request $request)
    {
        // Base query, eager‑load user + nested order→workType→designPayment
        $query = PostDesignersWork::with('user', 'order.workType.designPayment');

        // Month‑Year filter on created_at
        if ($request->filled('month_year')) {
            // incoming format is "YYYY-MM"
            [$year, $month] = explode('-', $request->month_year);
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }

        // User filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // (You can add other filters the same way…)

        // Execute
        $entries = $query->orderBy('created_at', 'desc')->get();

        // Dropdowns
        $users    = User::orderBy('name')->get();
        $invoices = Invoice::where('due_date', Carbon::today())->get();

        return view('call_center.designers-work-done', compact(
            'entries','users','invoices','request'
        ));
    }
}
