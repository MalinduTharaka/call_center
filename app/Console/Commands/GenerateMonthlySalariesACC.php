<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SalaryRate;
use App\Models\Salary;
use Carbon\Carbon;

class GenerateMonthlySalariesACC extends Command
{
    protected $signature = 'salary:generate:acc';

    protected $description = 'Generate salary records for all ACC users at the end of each month';

    public function handle()
    {
        $salaryForMonth = Carbon::now()
            ->subMonth()
            ->endOfMonth()
            ->format('Y-m-d');

        $rate = SalaryRate::where('role', 'acc')->first();

        if (!$rate) {
            if ($this->output) {
                $this->error('No SalaryRate found for role = acc');
            }
            return 1;
        }

        $users = User::where('role', 'acc')->get();

        foreach ($users as $user) {
            $exists = Salary::where('user_id', $user->id)
                ->where('month', $salaryForMonth)
                ->exists();

            if ($exists) {
                if ($this->output) {
                    $this->info("Skipped user {$user->id}: already has salary for {$salaryForMonth}");
                }
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

            if ($this->output) {
                $this->info("Created salary for user {$user->id} for {$salaryForMonth}");
            }
        }

        return 0;
    }
}
