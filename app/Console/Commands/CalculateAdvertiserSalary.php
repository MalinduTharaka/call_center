<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdvertiserWork;
use App\Models\Salary;
use App\Models\SalaryRate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CalculateAdvertiserSalary extends Command
{
    protected $signature = 'salary:calculate-advertisers';
    protected $description = 'Calculate advertiser salaries for the previous month';

    public function handle()
    {
        Log::info('Starting advertiser salary calculation...');

        $startOfMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $month = Carbon::now()->subMonth()->startOfMonth()->toDateString();

        Log::info("Salary period: $startOfMonth to $endOfMonth");

        $advertiserRate = SalaryRate::where('role', 'adv')->first();

        if (!$advertiserRate) {
            Log::error('No advertiser salary rate found.');
            return;
        }

        Log::info('Advertiser rate:', $advertiserRate->toArray());

        $advertiserUsers = User::where('role', 'adv')->get();

        foreach ($advertiserUsers as $user) {
            Log::info("Processing advertiser: {$user->id} - {$user->name}");

            $works = AdvertiserWork::where('user_id', $user->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->get();

            if ($works->isEmpty()) {
                Log::info("No works found for user {$user->id}.");
                continue;
            }

            $totalOtMinutes = $works->sum('ot');
            $otHours = $totalOtMinutes / 60;
            $otPay = $otHours * $advertiserRate->ot;

            $bonusTotal = $works->sum(function ($work) use ($advertiserRate) {
                $completeTime = Carbon::parse($work->complete_time);
                $cutoffTime = Carbon::parse($work->date . ' 19:00:00');

                if ($completeTime->lessThan($cutoffTime)) {
                    $diff = max(0, $work->wte_add_count - $work->target);
                    return $diff * $advertiserRate->ad_bonus;
                }
                return 0;
            });

            Log::info("User {$user->id}: OT Pay = $otPay, Bonus = $bonusTotal");

            $salary = new Salary();
            $salary->user_id = $user->id;
            $salary->month = $month;
            $salary->basic = $advertiserRate->basic;
            $salary->allowance = $advertiserRate->allowance;
            $salary->bonus = $bonusTotal;
            $salary->ot = $otPay;
            $salary->transport = $advertiserRate->transport;
            $salary->leave = 0;
            $salary->late = 0;
            $salary->attendace_bonus = 0;
            $salary->deduction = 0;

            $salary->net_salary =
                $salary->basic +
                $salary->allowance +
                $salary->bonus +
                $salary->ot +
                $salary->transport;

            $salary->save();

            Log::info("Salary saved for user {$user->id}. Net: {$salary->net_salary}");
        }

        Log::info('Advertiser salary calculation completed.');
    }
}
