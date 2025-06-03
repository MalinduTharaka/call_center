<?php

use App\Console\Commands\CroTargetUpdateSchedule;
use App\Console\Commands\GenerateMonthlySalariesACC;
use App\Console\Commands\GenerateMonthlySalariesUCA;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\UpdateAdvertiserAddCountAT5Schedule;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Use at the top in order to import your command file

 Artisan::command('advertiser:update-wte', function () {
    $command = new UpdateAdvertiserAddCountAT5Schedule();
    $command->handle();
})->describe('Update Advertiser Add Count At 7 PM');

Artisan::command('salary:generate:uca', function () {
    $command = new GenerateMonthlySalariesUCA();
    $command->handle();
})->describe('Update Advertiser Add Count At 7 PM');

Artisan::command('salary:generate:acc', function () {
    $command = new GenerateMonthlySalariesACC();
    $command->handle();
})->describe('Update Advertiser Add Count At 7 PM');

Artisan::command('app:cro-target', function () {
    $command = new CroTargetUpdateSchedule();
    $command->handle();
})->describe('Update Advertiser Add Count At 7 PM');

// Artisan::command('salary:generate-cro', function () {
//     $command = new GenerateCROSalary();
//     $command->handle();
// })->describe('Update Advertiser Add Count At 7 PM');

// Artisan::command('salary:calculate-advertisers', function () {
//     $command = new CalculateAdvertiserSalary();
//     $command->handle();
// })->describe('Update Advertiser Add Count At 7 PM');

