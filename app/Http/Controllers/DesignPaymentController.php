<?php

namespace App\Http\Controllers;

use App\Models\DesignPayment;
use App\Models\Invoice;
use App\Models\WorkType;
use Illuminate\Http\Request;

class DesignPaymentController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        $payments  = DesignPayment::with('workType')->get();
        $workTypes = WorkType::where('order_type','designs')->get();

        return view('call_center.design-payment', compact('payments', 'workTypes','invoices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'work_type_id' => 'required|exists:work_types,id',
            'amount'       => 'required|numeric|min:0',
        ]);

        DesignPayment::create($data);

        return redirect()->route('design.payments.index')
                         ->with('success', 'Payment added successfully.');
    }

    public function update(Request $request, DesignPayment $designPayment)
    {
        $data = $request->validate([
            'work_type_id' => 'required|exists:work_types,id',
            'amount'       => 'required|numeric|min:0',
        ]);

        $designPayment->update($data);

        return redirect()->route('design.payments.index')
                         ->with('success', 'Payment updated successfully.');
    }

    public function destroy(DesignPayment $designPayment)
    {
        $designPayment->delete();

        return redirect()->route('design.payments.index')
                         ->with('success', 'Payment deleted successfully.');
    }
}
