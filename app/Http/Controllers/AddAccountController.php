<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\AddAccount;

class AddAccountController extends Controller
{
    public function index(){
        $addAccount = AddAccount::all();
        $invoices = Invoice::all();
        return view('admin.add-accounts', compact('addAccount', 'invoices'));
    }
}
