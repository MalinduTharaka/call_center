<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddAccount;

class AddAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addAccounts = AddAccount::all();
        return view('admin.add-accounts', compact('addAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_account');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // dd($request->all());
    // Validate input
    $validatedData = $request->validate([
        'name'     => 'required|string|max:255',
        'code'     => 'required|string|max:255',
        'email'    => 'required|email|max:255|unique:add_accounts,email',
        'phone'    => 'required|string|max:20',
        'password' => 'nullable|string|min:6',
    ]);

    // // Hash password if provided
    // if (!empty($validatedData['password'])) {
    //     $validatedData['password'] = bcrypt($validatedData['password']);
    // }

    // Save data
    AddAccount::create($validatedData);

    return redirect('/add-account')->with('success', 'Account created successfully.');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $addAccount = AddAccount::findOrFail($id);
        return view('edit_account', compact('addAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'code'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:add_accounts,email,'.$id,
            'phone'    => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $addAccount = AddAccount::findOrFail($id);
        $addAccount->update($validatedData);

        return redirect('/add-account')->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $addAccount = AddAccount::findOrFail($id);
        $addAccount->delete();

        return redirect('/add-account')
            ->with('success', 'Account deleted successfully.');
    }
}
