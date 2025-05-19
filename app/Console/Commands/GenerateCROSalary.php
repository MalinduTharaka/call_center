<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\CallCenterWork;
use App\Models\Salary;
use App\Models\SalaryRate;
use Carbon\Carbon;

class GenerateCROSalary extends Command
{
    protected $signature = 'salary:generate-cro';
    protected $description = 'Generate salary for CRO users based on last month call center performance';

    public function handle()
    {
        $lastMonth = Carbon::now()->subMonth()->toDateString(); // e.g. 2025-04-01

        $users = User::where('role', 'cro')->get();

        foreach ($users as $user) {
            $salaryRate = SalaryRate::where('role', 'cro')->first();
            if (!$salaryRate) continue;

            $works = CallCenterWork::with('target')
                ->where('user_id', $user->id)
                ->whereMonth('month', Carbon::parse($lastMonth)->month)
                ->whereYear('month', Carbon::parse($lastMonth)->year)
                ->get();

            $bonus = 0;

            foreach ($works as $work) {
                $target = $work->target;
                if (!$target) continue;

                $diff = $work->order_count - $target->target;
                if ($diff > 0) {
                    if ($target->target_category === 'boosting') {
                        $bonus += $diff * $salaryRate->b_bonus;
                    } elseif ($target->target_category === 'video') {
                        $bonus += $diff * $salaryRate->v_bonus;
                    }
                }
            }

            // Create salary record
            Salary::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'month' => $lastMonth
                ],
                [
                    'basic' => $salaryRate->basic,
                    'allowance' => $salaryRate->allowance,
                    'transport' => $salaryRate->transport,
                    'attendace_bonus' => $salaryRate->at_bonus,
                    'bonus' => $bonus,
                    'ot' => 0,
                    'leave' => 0,
                    'late' => 0,
                    'deduction' => 0,
                    'net_salary' => $salaryRate->basic + $salaryRate->allowance + $salaryRate->transport + $salaryRate->at_bonus + $bonus,
                ]
            );
        }

        $this->info("CRO salaries generated for $lastMonth.");
    }
}
