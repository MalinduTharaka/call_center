<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PostDesignersWork;
use Illuminate\Http\Request;

class DesignersWorkDoneController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        // eager‑load user, workType and the linked designPayment
        $entries = PostDesignersWork::with(['user'])->get();

        return view('call_center.designers-work-done', compact('entries','invoices'));
    }
}
