<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected $commands = [
        \App\Console\Commands\CroTargetUpdateSchedule::class,

        \App\Console\Commands\GenerateMonthlySalariesUCA::class,

        \App\Console\Commands\GenerateMonthlySalariesACC::class,   // ACC

        \App\Console\Commands\UpdateAdvertiserAddCountAT5Schedule::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Example: Run the command every day at midnight
        $schedule->command('app:cro-target')->everyMinute();

        $schedule->command('salary:generate:uca')
            ->monthlyOn(1, '00:00')
            ->runInBackground();

        // ACC payroll: also 00:00 on the 1st
        $schedule->command('salary:generate:acc')
            ->monthlyOn(1, '00:00')
            ->runInBackground();
        
        // $schedule->command('advertiser:update-wte')->dailyAt('17:00');
        $schedule->command('advertiser:update-wte')->everyMinute();
    }

    /**
     * Register the closure-based commands.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
