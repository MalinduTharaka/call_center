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
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Example: Run the command every day at midnight
        $schedule->command('app:cro-target')->everyMinute();
    }

    /**
     * Register the closure-based commands.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
