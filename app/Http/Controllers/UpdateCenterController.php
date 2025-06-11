<?php

namespace App\Http\Controllers;

use App\Events\DesignersPaymentsUpdateEvent;
use App\Models\EditorsWork;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Package;
use App\Models\PostDesignersWork;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateCenterController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 2. Parse their from_date/to_date (and optionally normalize to full days)
        $from = Carbon::parse($user->from_date)->startOfDay();
        $to = Carbon::parse($user->to_date)->endOfDay();

        $orders = Order::whereBetween('created_at', [$from, $to])
            ->where('ps', '1')
            ->orderBy('created_at', 'desc')->get();
        $users = User::all();
        $invoices = Invoice::where('due_date', Carbon::today())->paginate(1);
        $work_types = WorkType::all();
        return view('update_center.update-center', compact('orders', 'users', 'invoices', 'work_types'));
    }

    public function updateVideoUC(Request $request, $id)
    {
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
    public function updateDesignsUC(Request $request, $id)
    {
        $uc = Order::findOrFail($id);
        $uc->update($request->all());
        event(new DesignersPaymentsUpdateEvent($id));
        if ($request->designer_id) {
            // Check if an EditorsWork row already exists for this order_id
            $existing = PostDesignersWork::where('order_id', $id)->first();

            if (!$existing) {
                PostDesignersWork::create([
                    'user_id' => $request->designer_id,
                    'order_id' => $id,
                    'month' => Carbon::now(),
                ]);
            }
        }
        return redirect()->back()->with('success', 'Order Update Done');
    }
}
