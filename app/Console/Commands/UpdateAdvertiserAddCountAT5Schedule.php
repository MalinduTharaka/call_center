<?php

namespace App\Console\Commands;

use App\Models\AdvertiserWork;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateAdvertiserAddCountAT5Schedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'advertiser:update-wte';

    /**
     * The console command description.
     *
     * @var string
     */
   protected $description = 'Update wte_add_count with add_count for today\'s advertiser work records';

    /**
     * Execute the console command.
     */

        

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        AdvertiserWork::where('date', $today)
            ->update([
                'wte_add_count' => DB::raw('add_count')
            ]);

        $this->info('wte_add_count updated for today\'s records.');
    }
}
