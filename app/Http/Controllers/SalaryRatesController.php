<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\SalaryRate;
use App\Models\User;
use Illuminate\Http\Request;

class SalaryRatesController extends Controller
{
    public function index(){
        $invoices = Invoice::all();
        $rates = SalaryRate::all();
        $users = User::all();
        return view('salary_rates.salary_rates', compact('invoices', 'rates', 'users'));
    }

    public function store(Request $request){
        SalaryRate::create($request->all());
        return redirect()->back()->with('success', 'Salary rate added Successfully');
    }
    public function update(Request $request, $id){
        $rate = SalaryRate::findOrFail($id);
        $rate->update($request->all());
        return redirect()->back()->with('success', 'Salary rate updated Successfully');
    }
    public function delete($id){
        $rate = SalaryRate::findOrFail($id);
        $rate->delete();
        return redirect()->back()->with('success', 'Salary rate deleted Successfully');
    }
}
