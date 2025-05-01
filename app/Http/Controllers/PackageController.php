<?php


namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $invoices = Invoice::all();
        return view('admin.packages', compact('packages', 'invoices'));
    }

    public function storepkg(Request $request)
    {
        $request->validate([
            'package_amount' => 'required|numeric',
            'tax' => 'required|numeric',
            'service' => 'required|numeric',
            'full' => 'required|numeric',
        ]);

        Package::create($request->all());
        return redirect()->back()->with('success', 'Package Stored Successfully');
    }

    public function updatepkg(Request $request)
    {
        $request->validate([
            'package_amount' => 'required|numeric',
            'tax' => 'required|numeric',
            'service' => 'required|numeric',
            'full' => 'required|numeric',
        ]);

        $package = Package::findOrFail($request->id);
        $package->update($request->only(['package_amount', 'tax', 'service']));

        return redirect()->back()->with('success', 'Package Updated Successfully');
    }

    public function deletepkg($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->back()->with('success', 'Package Deleted Successfully');
    }
}