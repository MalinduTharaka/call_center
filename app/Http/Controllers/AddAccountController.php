<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddAccount;

class AddAccountController extends Controller
{
    public function index(){
        $addAccount = AddAccount::all();
        return view('admin.add-accounts', compact('addAccount'));
    }
}
