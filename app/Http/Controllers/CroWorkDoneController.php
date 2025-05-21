<?php

namespace App\Http\Controllers;

use App\Models\CallCenterWork;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CroWorkDoneController extends Controller
{
    public function index()
{
    $invoices = Invoice::where('due_date', Carbon::today())->get();
    $callCenterWorks = CallCenterWork::all();
    return view('call_center.cro-work-done', compact('callCenterWorks','invoices'));
}
}
