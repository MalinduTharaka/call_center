<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SalaryRate;
use App\Models\Salary;
use Carbon\Carbon;

class GenerateMonthlySalariesACC extends Command
{
    // Changed signature so it won’t conflict with UCA
    protected $signature = 'salary:generate:acc';

    protected $description = 'Generate salary records for all ACC users at the end of each month';

    public function handle()
    {
        // Here we record the 1st day of the PREVIOUS month
        $salaryForMonth = Carbon::now()
            ->subMonth()
            ->endOfMonth()
            ->format('Y-m-d');   // e.g. "2025-04-01"

        $rate = SalaryRate::where('role', 'acc')->first();

        if (!$rate) {
            return $this->error('No SalaryRate found for role = acc');
        }

        $users = User::where('role', 'acc')->get();

        foreach ($users as $user) {
            if (Salary::where('user_id', $user->id)
                      ->where('month', $salaryForMonth)
                      ->exists()) {
                $this->info("Skipped user {$user->id}: already has salary for {$salaryForMonth}");
                continue;
            }

            Salary::create([
                'user_id'         => $user->id,
                'month'           => $salaryForMonth,
                'basic'           => $rate->basic,
                'allowance'       => $rate->allowance,
                'transport'       => $rate->transport,
                'attendace_bonus' => 0,
                'net_salary'      => $rate->basic + $rate->allowance + $rate->transport,
            ]);

            $this->info("Created salary for user {$user->id} for {$salaryForMonth}");
        }

        return 0;
    }
}
