<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        $users = User::all();

        $previousMonth = Carbon::now()->subMonth();
        $salariesTM = Salary::whereMonth('month', $previousMonth->month)
            ->whereYear('month', $previousMonth->year)
            ->get();
        return view('salary.salaries', compact('invoices', 'users', 'salariesTM'));
    }

    public function selectedMonth($mo, $yr)
    {
        $salaries = Salary::with('user')
            ->whereMonth('month', $mo)
            ->whereYear('month', $yr)
            ->get();

        return response()->json($salaries);
    }

    public function editSalary(Request $request, $id){
        $salaries = Salary::findOrFail($id);
        $salaries->update($request->all());
        $salaries->save();
        return redirect()->back()->with('success','Salary Updated Successfully');
    }

}
