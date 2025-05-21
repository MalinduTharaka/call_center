<?php

namespace App\Http\Controllers;

use App\Models\EditorsWork;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderUpdate;
use App\Models\OtherOrder;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function indexo(){
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::whereBetween('created_at', [$from, $to])
        ->where('ps', '1')
        ->orderBy('created_at', 'desc')->get();
        $users = User::all();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $work_types = WorkType::all();
        return view('admin.admin-orders', compact('orders', 'users', 'invoices', 'work_types'));
    }

    public function updateBoostingAD(Request $request, $id){
        $uc = Order::findOrFail($id);
        $uc->update([
            'add_acc' => $request->add_acc,
            'ce' => $request->ce,
            'name' => $request->name,
            'contact' => $request->contact,
            'work_type_id' => $request->work_type,
            'page' => $request->page,
            'work_status' => $request->work_status,
            'payment_status' => $request->payment_status,
            'cash' => $request->cash,
            'advertiser_id' => $request->advertiser_id,
            'package_amt' => $request->package_amt,
            'service' => $request->service,
            'tax' => $request->tax,
            'details' => $request->details,
            'add_acc_id' => $request->add_acc_id,
        ]);

        $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
        if($request->package_amt > $request->package_amtold){
            $invoice->update([
                'total' => $invoice->total + ($request->package_amt - $request->package_amtold)
            ]);
        }else{
            $invoice->update([
                'total' => $invoice->total - ($request->package_amtold - $request->package_amt)
            ]);
        }
        if($request->service > $request->serviceold){
            $invoice->update([
                'total' => $invoice->total + ($request->service - $request->serviceold)
            ]);
        }else{
            $invoice->update([
                'total' => $invoice->total - ($request->serviceold - $request->service)
            ]);
        }
        if($request->tax > $request->taxold){
            $invoice->update([
                'total' => $invoice->total + ($request->tax - $request->taxold)
            ]);
        }else{
            $invoice->update([
                'total' => $invoice->total - ($request->taxold - $request->tax)
            ]);
        }



        return redirect()->back()->with('success', 'Boosting Order Update Done');
    }

    public function updateDesignsAD(Request $request, $id){
        $uc = Order::findOrFail($id);
        $uc->update([
            'ce' => $request->ce,
            'name' => $request->name,
            'contact' => $request->contact,
            'work_type_id' => $request->work_type,
            'work_status' => $request->work_status,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
        ]);


        $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
        if($request->amount > $request->amountold){
            $invoice->update([
                'total' => $invoice->total + ($request->amount - $request->amountold)
            ]);
        }else{
            $invoice->update([
                'total' => $invoice->total - ($request->amountold - $request->amount)
            ]);
        }

        return redirect()->back()->with('success', 'Designs Order Update Done');
    }

    public function updateVideoAD(Request $request, $id){
        $uc = Order::findOrFail($id);
        $uc->update([
            'ce' => $request->ce,
            'name' => $request->name,
            'contact' => $request->contact,
            'amount' => $request->amount,
            'our_amount' => $request->our_amount,
            'work_type_id' => $request->work_type,
            'script' => $request->script,
            'shoot' => $request->shoot,
            'work_status' => $request->work_status,
            'payment_status' => $request->payment_status,
            'cash' => $request->cash,
        ]);


        $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
        if($request->amount > $request->amountold){
            $invoice->update([
                'total' => $invoice->total + ($request->amount - $request->amountold)
            ]);
        }else{
            $invoice->update([
                'total' => $invoice->total - ($request->amountold - $request->amount)
            ]);
        }
    
        return redirect()->back()->with('success', 'Video Order Update Done');
    }
    

    public function indexOR(){
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $other_orders = OtherOrder::whereBetween('created_at', [$from, $to])->orderBy('date')
        ->where('ps', '1')
        ->orderBy('created_at', 'desc')->get();
        $slips = Slip::all();
        $users = User::all();
        return view('admin.admin-ordersOR', compact('other_orders',  'users', 'slips', 'invoices'));
    }

    public function updateOrAD(Request $request, $id){
        $uc = OtherOrder::findOrFail($id);
        $uc->update([
            'ce' => $request->ce,
            'name' => $request->name,
            'contact' => $request->contact,
            'work_status' => $request->work_status,
            'payment_status' => $request->payment_status,
            'cash' => $request->cash,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
        if($request->amount > $request->amountold){
            $invoice->update([
                'total' => $invoice->total + ($request->amount - $request->amountold)
            ]);
        }else{
            $invoice->update([
                'total' => $invoice->total - ($request->amountold - $request->amount)
            ]);
        }
        return redirect()->back()->with('success', 'Other Order Update Done');
    }

    public function updateSheetView(){
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $orders = OrderUpdate::whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();
        $users = User::all();
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $work_types = WorkType::all();
        return view('admin.update-sheet', compact('orders',  'users', 'invoices', 'work_types'));
    }

    public function BoostingUpdateSheet(Request $request){
        $order = Order::findOrFail($request->order_id);
        OrderUpdate::create([
            'order_id' => $request->order_id,
            'invoice_id' => $order->invoice,
            'date' => $order->created_at,
            'name' => $order->name,
            'cro' => $order->uid,
            'contact' => $order->contact,
            'work_type' => $order->work_type_id,
            'page' => $order->page,
            'update' => $request->update,
            'advertiser_id' => $order->advertiser_id,
            'add_acc_id' => $order->add_acc_id,
            'add_acc' => $order->add_acc,
        ]);
        return redirect()->route('updatesheetView')->with('success', 'Order Added To update sheet');
    }

    public function BoostingUpdateSheetEdit(Request $request, $id){
        $order = OrderUpdate::findOrFail($id);
        $order->update($request->all());
        return redirect()->route('updatesheetView')->with('success', 'update Done');
    }
}
