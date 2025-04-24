<?php

namespace App\Http\Controllers;

use App\Models\AddCenter;
use App\Models\CallCenter;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
class AssignEmployeesController extends Controller
{
    public function index(){
        $users = User::all();
        $call_centers = CallCenter::all();
        $add_centers = AddCenter::all();
        $invoices = Invoice::all();
        return view('admin.assign-employees', compact('users', 'call_centers', 'add_centers', 'invoices'));
    }

    public function storecc(Request $request){
        CallCenter::create($request->all());
        return redirect()->back()->with('success', 'Call Center Added Successfully');
    }

    public function storeac(Request $request){
        AddCenter::create($request->all());
        return redirect()->back()->with('success', 'Add Center Added Successfully');
    }

    public function updatecc(Request $request, $id){
        $call_center = CallCenter::findOrFail($id);
        $call_center->update($request->all());
        return redirect()->back()->with('success', 'Call Center Updated Successfully');
    }

    public function updateac(Request $request, $id){
        $add_center = AddCenter::findOrFail($id);
        $add_center->update($request->all());
        return redirect()->back()->with('success', 'Add Center Updated Successfully');
    }

    public function deletecc($id){
        $call_center = CallCenter::findOrFail($id);
        $call_center->delete();
        return redirect()->back()->with('success', 'Call Center Deleted Successfully');
    }

    public function deleteac($id){
        $add_center = AddCenter::findOrFail($id);
        $add_center->delete();
        return redirect()->back()->with('success', 'Add Center Deleted Successfully');
    }
}
