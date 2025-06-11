<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

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
        // cro-target: every day at 11 PM
        $schedule->command('app:cro-target')->dailyAt('23:00');

        // advertiser:update-wte: every day at 7 PM
        $schedule->command('advertiser:update-wte')->dailyAt('19:00');

        // salary:generate-cro: every month start day at 8 PM
        $schedule->command('salary:generate-cro')->monthlyOn(1, '20:00');

        // salary:calculate-advertisers: every month start day at 10 PM
        $schedule->command('salary:calculate-advertisers')->monthlyOn(1, '22:00');

        // salary:generate:uca: every month 2nd day at 10 PM
        $schedule->command('salary:generate:uca')->monthlyOn(2, '22:00');

        // salary:generate:acc: every month 2nd day at 11 PM
        $schedule->command('salary:generate:acc')->monthlyOn(2, '23:00');
    })


    ->create();
