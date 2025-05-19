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

        \App\Console\Commands\GenerateCROSalary::class,
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

        $schedule->command('salary:generate-cro')->monthlyOn(1, '00:00');
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
