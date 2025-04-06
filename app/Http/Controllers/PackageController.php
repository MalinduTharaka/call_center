<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    public function index(){
        $packages = Package::all();
        $invoices = Invoice::all();
        return view('admin.packages', compact('packages', 'invoices'));
    }
}
