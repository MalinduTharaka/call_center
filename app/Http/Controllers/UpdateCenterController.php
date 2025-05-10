<?php

namespace App\Http\Controllers;

use App\Events\DesignersPaymentsUpdateEvent;
use App\Models\EditorsWork;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Package;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateCenterController extends Controller
{
    public function index(){
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to   = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();
        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();
        return view('update_center.update-center', compact('orders', 'packages', 'users', 'slips', 'invoices', 'work_types', 'video_pkgs'));
    }

    public function updateVideoUC(Request $request, $id){
        $uc = Order::findOrFail($id);
        $uc->update($request->all());
    
        if ($request->editor_id) {
            // Check if an EditorsWork row already exists for this order_id
            $existing = EditorsWork::where('order_id', $id)->first();
    
            if (!$existing) {
                EditorsWork::create([
                    'user_id' => $request->editor_id,
                    'order_id' => $id,
                    'work_type' => $request->work_type,
                    'duration' => $request->video_time,
                    'date' => Carbon::now(),
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Order Update Done');
    }
    public function updateDesignsUC(Request $request, $id){
        $uc = Order::findOrFail($id);
        $uc->update($request->all());
        event(new DesignersPaymentsUpdateEvent($id));
        return redirect()->back()->with('success', 'Order Update Done');
    }
}
