<?php

namespace App\Http\Controllers;

use App\Models\CallCenterWork;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CroWorkDoneController extends Controller
{
    public function index()
{
    $invoices = Invoice::all();
    $callCenterWorks = CallCenterWork::all();
    return view('call_center.cro-work-done', compact('callCenterWorks','invoices'));
}
}
