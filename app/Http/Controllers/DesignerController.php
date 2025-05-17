<?php

namespace App\Http\Controllers;

use App\Events\DesignersPaymentsUpdateEvent;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\WorkType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DesignerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::whereBetween('created_at', [$from, $to])
            ->where('ps', '1')
            ->where( 'designer_id', Auth::user()->id)
            ->where('order_type', 'designs')
            ->orderBy('created_at', 'desc')->get();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        return view('designers.designer', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types'));
    }

    public function updareDesigner(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Updates all fields from the request

        event(new DesignersPaymentsUpdateEvent($id));

        return redirect()->back()->with('success', 'Order Updated Successfully');
    }

    public function DesignImageUpload(Request $request, $id)
    {
        // 1) Validate incoming request
        $request->validate([
            'slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2) Find the order
        $order = Order::findOrFail($id);

        // 3) Handle image upload into public/designs
        if (!$request->hasFile('slip') || !$request->file('slip')->isValid()) {
            return back()->with('error', 'Image upload failed or no file provided.');
        }

        $file = $request->file('slip');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Ensure the public/designs directory exists
        $destination = public_path('designs');
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        // Move the uploaded file
        $file->move($destination, $filename);

        // Build the public-relative path
        $imagePath = 'designs/' . $filename;

        // 4) Save the image path to the order
        $order->d_img = $imagePath;
        $order->save();

        return redirect()->back()->with('success', 'Design image uploaded successfully.');
    }


}
