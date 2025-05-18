<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use App\Models\Package;
use App\Models\Salary;
use App\Models\Slip;
use App\Models\User;
use App\Models\VideoPkg;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $salaries = Salary::where("user_id", Auth::user()->id)
            ->whereYear('month', Carbon::now()->year)
            ->get();
        $attendances = Attendance::where('user_id', Auth::user()->id)
            ->whereMonth('date', Carbon::now()->month)
            ->get();
        // Fetch all your collections
        $orders = Order::all();

        $packages = Package::all();
        $users = User::all();
        $slips = Slip::all();
        $invoices = Invoice::all();
        $work_types = WorkType::all();
        $video_pkgs = VideoPkg::all();

        $user = Auth::user();
        $ccNum = $user->cc_num;
        $uID = $user->id;

        $other_orders = OtherOrder::where('cc_id', $ccNum)->where('ps', '1')->get();

        // Fetch by type/ps
        $boosting = Order::where('order_type', 'boosting')->where('ps', '1')->where('cro', $ccNum)->get();
        $designs = Order::where('order_type', 'designs')->where('ps', '1')->where('cro', $ccNum)->get();
        $video = Order::where('order_type', 'video')->where('ps', '1')->where('cro', $ccNum)->get();


        $other_orders_user = OtherOrder::where('user_id', $uID)->where('ps', '1')->get();
        $boosting_user = Order::where('order_type', 'boosting')->where('ps', '1')->where('uid', $uID)->get();
        $designs_user = Order::where('order_type', 'designs')->where('ps', '1')->where('uid', $uID)->get();
        $video_user = Order::where('order_type', 'video')->where('ps', '1')->where('uid', $uID)->get();
        // your OtherOrder model already is filtered by ps?
        // if not, add ->where('ps','1') as needed
        $otherOrders = OtherOrder::where('cc_id', $ccNum)->where('ps', '1')->get();

        // Common date boundaries
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        /**
         * Build a summary array [today, this_month, this_year, all]
         * $collection       = a Laravel Collection of Eloquent models
         * $valueCallback    = fn($model) => numeric value to sum
         */
        $makeSummary = function ($collection, callable $valueCallback) use ($today, $startOfMonth, $startOfYear) {
            return [
                'today' => $collection
                    ->filter(fn($m) => Carbon::parse($m->created_at)->isSameDay($today))
                    ->sum($valueCallback),
                'this_month' => $collection
                    ->filter(fn($m) => Carbon::parse($m->created_at)->gte($startOfMonth))
                    ->sum($valueCallback),
                'this_year' => $collection
                    ->filter(fn($m) => Carbon::parse($m->created_at)->gte($startOfYear))
                    ->sum($valueCallback),
                'all' => $collection->sum($valueCallback),
            ];
        };

        // Boosting: done => service+tax+package_amt, else => advance
        $boostingSummary = $makeSummary($boosting, function ($o) {
            return $o->payment_status === 'done'
                ? ($o->service + $o->tax + $o->package_amt)
                : $o->advance;
        });

        // Designs: done => amount, else => advance
        $designsSummary = $makeSummary($designs, function ($o) {
            return $o->payment_status === 'done'
                ? $o->amount
                : $o->advance;
        });

        // Video: done => amount, else => advance
        $videoSummary = $makeSummary($video, function ($o) {
            return $o->payment_status === 'done'
                ? $o->amount
                : $o->advance;
        });

        // Other Orders: done => amount, else => advance
        $otherSummary = $makeSummary($otherOrders, function ($o) {
            return $o->payment_status === 'done'
                ? $o->amount
                : $o->advance;
        });

        return view('profile.user-profile', compact(
            'salaries',
            'attendances',
            'orders',
            'other_orders',
            'packages',
            'users',
            'slips',
            'invoices',
            'work_types',
            'video_pkgs',
            'boosting',
            'designs',
            'video',
            'otherOrders',
            'other_orders_user',
            'boosting_user',
            'designs_user',
            'video_user',
            'boostingSummary',
            'designsSummary',
            'videoSummary',
            'otherSummary'
        ));
    }
}
