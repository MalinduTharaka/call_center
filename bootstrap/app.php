<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->withSchedule(function(Schedule $schedule){
    // 1. Run on last day of the month at 8:00 PM
    $schedule->command('app:cro-target')
        ->when(fn () => now()->isLastOfMonth())
        ->dailyAt('20:00');

    // 2. First day of month at 10:00 PM
    $schedule->command('salary:generate:uca')->monthlyOn(1, '22:00');

    // 3. First day of month at 10:30 PM
    $schedule->command('salary:generate:acc')->monthlyOn(1, '22:30');

    // 4. First day of month at 11:00 PM
    $schedule->command('salary:generate-cro')->monthlyOn(1, '23:00');

    // 5. Every day at 7:00 PM
    $schedule->command('advertiser:update-wte')->dailyAt('19:00');

    // 6. First day of month at 11:30 PM
    $schedule->command('salary:calculate-advertisers')->monthlyOn(1, '23:30');
})

    
    ->create();
