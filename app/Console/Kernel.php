<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:cro-target')->everyMinute();

        $schedule->command('salary:generate:uca')->everyMinute();

        // ACC payroll: also 00:00 on the 1st
        $schedule->command('salary:generate:acc')->everyMinute();
        
        // $schedule->command('advertiser:update-wte')->dailyAt('17:00');
        $schedule->command('advertiser:update-wte')->everyMinute();

        $schedule->command('salary:generate-cro')->everyMinute();

        // $schedule->command('salary:calculate-advertisers')->monthlyOn(1, '00:00');
        $schedule->command('salary:calculate-advertisers')->everyMinute();
    }
}
