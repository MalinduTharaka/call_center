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
        $lastMonth = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d'); // Use consistent format for month

        $users = User::where('role', 'cro')->get();

        if ($users->isEmpty()) {
            if ($this->output) {
                $this->info("No CRO users found.");
            }
            return 0;
        }

        $salaryRate = SalaryRate::where('role', 'cro')->first();
        if (!$salaryRate) {
            if ($this->output) {
                $this->error("No SalaryRate found for role = cro");
            }
            return 1;
        }

        foreach ($users as $user) {
            $bonus = 0;

            $works = CallCenterWork::with('target')
                ->where('user_id', $user->id)
                ->whereMonth('month', Carbon::parse($lastMonth)->month)
                ->whereYear('month', Carbon::parse($lastMonth)->year)
                ->get();

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

            Salary::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'month' => $lastMonth
                ],
                [
                    'basic'           => $salaryRate->basic,
                    'allowance'       => $salaryRate->allowance,
                    'transport'       => $salaryRate->transport,
                    'attendace_bonus' => $salaryRate->at_bonus,
                    'bonus'           => $bonus,
                    'ot'              => 0,
                    'leave'           => 0,
                    'late'            => 0,
                    'deduction'       => 0,
                    'net_salary'      => $salaryRate->basic + $salaryRate->allowance + $salaryRate->transport + $salaryRate->at_bonus + $bonus,
                ]
            );
        }

        if ($this->output) {
            $this->info("CRO salaries generated for $lastMonth.");
        }

        return 0;
    }
}
