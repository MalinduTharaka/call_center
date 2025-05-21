<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeCalculatorController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('due_date', Carbon::today())->get();
        $startOfMonth = Carbon::now()->startOfMonth()->subMonth();
        $endOfMonth = Carbon::now()->endOfMonth()->subMonth();

        $boostingServiceSum = DB::table('orders')
            ->where('ps', '1')
            ->where('order_type', 'boosting')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw("SUM(service) as total")
            ->value('total');

        $designsAmountSum = DB::table('orders')
            ->where('ps', '1')
            ->where('order_type', 'designs')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw("SUM(CASE WHEN payment_status = 'done' THEN amount ELSE advance END) as total")
            ->value('total');

        $videoAmountSum = DB::table('orders')
            ->where('ps', '1')
            ->where('order_type', 'video')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw("SUM(CASE WHEN payment_status = 'done' THEN amount ELSE advance END) as total")
            ->value('total');

        $othersum = DB::table('other_orders')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('ps', '1')
            ->selectRaw("SUM(CASE WHEN payment_status = 'done' THEN amount ELSE advance END) as total")
            ->value('total');
            
        $salaries = DB::table(table: 'salaries')
            ->whereBetween('month', [$startOfMonth, $endOfMonth])
            ->sum('net_salary');
        
        $actorSalaries = DB::table(table: 'actors_works')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        $designerSalaries = DB::table(table: 'post_designers_works')
            ->whereBetween('month', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $videoEditorSalaries = DB::table(table: 'editors_works')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        return view('salary.net-income-calculator', [
            'invoices' => $invoices,
            'boostingServiceSum' => $boostingServiceSum,
            'designsAmountSum' => $designsAmountSum,
            'videoAmountSum' => $videoAmountSum,
            'othersum' => $othersum,
            'salaries' => $salaries,
            'actorSalaries' => $actorSalaries,
            'designerSalaries' => $designerSalaries,
            'videoEditorSalaries' => $videoEditorSalaries,
        ]);
    }
}
