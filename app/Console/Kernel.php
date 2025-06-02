<?php

namespace App\Console;

use App\Console\Commands\UpdateAdvertiserAddCountAT5Schedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    // protected $commands = [
    //     \App\Console\Commands\CroTargetUpdateSchedule::class,

    //     \App\Console\Commands\GenerateMonthlySalariesUCA::class,

    //     \App\Console\Commands\GenerateMonthlySalariesACC::class,   // ACC

    //     \App\Console\Commands\UpdateAdvertiserAddCountAT5Schedule::class,
    // ];

    /**
     * Define the application's command schedule.
     */
    // protected function schedule(Schedule $schedule)
    // {
    //     // Example: Run the command every day at midnight
    //     $schedule->command('app:cro-target')->everyMinute();

    //     $schedule->command('salary:generate:uca')
    //         ->everyMinute();

    //     // ACC payroll: also 00:00 on the 1st
    //     $schedule->command('salary:generate:acc')
    //         ->everyMinute();

    //     // $schedule->command('advertiser:update-wte')->dailyAt('17:00');
    //     $schedule->command('advertiser:update-wte')->everyMinute();

    //     $schedule->call(function () {
    //         \Log::info('Schedule test log at ' . now());
    //     })->everyMinute();
    // }

    protected function schedule(Schedule $schedule)
    {
        // Log::info('🟡 Laravel schedule method loaded at ' . now());

        // $schedule->call(function () {
        //     Log::info('✅ Inline scheduled callback executed at ' . now());
        // })->everyMinute();

        // $schedule->command('app:cro-target')->everyMinute();
        // $schedule->command('salary:generate:uca')->everyMinute();
        // $schedule->command('salary:generate:acc')->everyMinute();
        // $schedule->command('advertiser:update-wte')->everyMinute();
        $schedule->call(function () {
    \Log::info("🔁 Simple inline schedule ran at: " . now());
        })->everyMinute();
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
