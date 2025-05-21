<?php

namespace App\Http\Controllers;

use App\Models\ActorsWork;
use App\Models\EditorsWork;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkDoneController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $videoEntries = EditorsWork::with('user')->latest()->get();
        $actorEntries = ActorsWork::with('user')->latest()->get();
        $users        = User::all();

        return view('call_center.work-done', compact('videoEntries', 'actorEntries', 'users','invoices'));
    }

}
