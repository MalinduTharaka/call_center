<?php

namespace App\Http\Controllers;

use App\Models\AddCenter;
use App\Models\CallCenter;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $call_centers = CallCenter::all();
        $add_centers = AddCenter::all();
        return view('admin.user-manage', compact('users', 'invoices', 'call_centers', 'add_centers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nic' => 'string|max:20',
            'contact' => 'required|string|max:15',
            'password' => 'required|min:8',
            'role' => 'required|string'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nic' => $request->nic,
            'contact' => $request->contact,
            'role' => $request->role,
            'password' => bcrypt($request->password)
        ]);
        return redirect()->back()->with('success', 'User Added Successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Deleted Successfully');
    }

    public function assignUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->cc_num = $request->cc_num;
        $user->ac_num = $request->ac_num;
        $user->save();
        return redirect()->back()->with('success', 'User Assigned Successfully');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'nic' => 'nullable|string',
            'contact' => 'nullable|string',
            'role' => 'required|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nic' => $request->nic,
            'contact' => $request->contact,
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function dateRange(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->back()->with('success', 'Date Range Added.');
    }

}
