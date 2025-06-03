<?php

use App\Console\Commands\UpdateAdvertiserAddCountAT5Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // Schedule using command name instead of class instantiation
        $schedule->command('app:cro-target')->everyMinute();
        $schedule->command('salary:generate:uca')->everyMinute();
        $schedule->command('salary:generate:acc')->everyMinute();
        $schedule->command('advertiser:update-wte')->everyMinute();
        $schedule->command('salary:generate-cro')->everyMinute();
        $schedule->command('salary:calculate-advertisers')->everyMinute();
    })
    ->create();
