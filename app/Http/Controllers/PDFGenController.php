<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class PDFGenController extends Controller
{
    public function index(){
        $invoices = Invoice::all();
        return view('pdf_maker.imgs-to-pdf', compact('invoices'));
    }
}
