<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PDFGenController extends Controller
{
    public function index(){
         $invoices = Invoice::where('due_date', Carbon::today())->get();
        return view('pdf_maker.imgs-to-pdf', compact('invoices'));
    }
}
