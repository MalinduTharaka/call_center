<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SalaryRate;
use App\Models\Salary;
use Carbon\Carbon;

class GenerateMonthlySalariesUCA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salary:generate:uca';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate salary records for all UCA users at the end of each month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Decide which month to record—for "last month" when you run on the 1st, or "this month" when run on the last day.
        // Here we assume this command will run at 00:00 on the 1st of each month to record the previous month:
        $salaryForMonth = Carbon::now()
            ->subMonth()           // go back 1 month
            ->endOfMonth()       // jump to the 1st of that month
            ->format('Y-m-d');   // e.g. "2025-04-01"

        // Fetch the rate row for UCA once
        $rate = SalaryRate::where('role', 'uca')->first();

        if (!$rate) {
            $this->error('No SalaryRate found for role = uca');
            return 1;
        }

        // Find all UCA users
        $users = User::where('role', 'uca')->get();

        foreach ($users as $user) {
            // Prevent duplicates
            $exists = Salary::where('user_id', $user->id)
                ->where('month', $salaryForMonth)
                ->exists();

            if ($exists) {
                $this->info("Skipped user {$user->id}: already has salary for {$salaryForMonth}");
                continue;
            }

            // Create salary record
            Salary::create([
                'user_id' => $user->id,
                'month' => $salaryForMonth,
                'basic' => $rate->basic,
                'allowance' => $rate->allowance,
                'transport' => $rate->transport,
                // you can default the rest to zero or null
                'attendace_bonus' => 0,
                'net_salary' => $rate->basic + $rate->allowance + $rate->transport,
            ]);

            $this->info("Created salary for user {$user->id} for {$salaryForMonth}");
        }

        return 0;
    }
}
