<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\WorkType;

class WorkTypeController extends Controller
{
    public function index(){
        $worktypes = WorkType::all();
        $invoices = Invoice::all();
        return view('admin.work-type', compact('worktypes', 'invoices'));
    }
}
