<?php

namespace App\Console\Commands;

use App\Enums\TargetStatusEnum;
use App\Models\CallCenter;
use App\Models\CallCenterWork;
use App\Models\Order;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CroTargetUpdateSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cro-target';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('CroTargetUpdateSchedule running');
        $this->info('CroTargetUpdateSchedule running');
    
        $users = User::where('role', 'cro')->get();
        \Log::info('Users fetched: ', $users->toArray());
    
        if ($users->isEmpty()) {
            $this->info('No users found');
            return;
        }
    
        $currentMonth = Carbon::now()->startOfMonth()->toDateString();
    
        // Get CRO targets for video and boosting
        $targets = Target::where('user_role', 'cro')
            ->whereIn('target_category', ['video', 'boosting'])
            ->get()
            ->keyBy('target_category');
    
        foreach ($users as $user) {
            foreach (['video', 'boosting'] as $category) {
                $target = $targets->get($category);
    
                if (!$target) {
                    $this->warn("No target found for category '{$category}'");
                    continue;
                }
    
                // Get order count for the current category (video/boosting)
                $orderCount = Order::where('user_id', $user->id)
                    ->where('ps', 1)
                    ->where('service', '>', 0)
                    ->where('order_type', $category)
                    ->count();
    
                $this->info("User {$user->id} | Category: {$category} | Order Count: {$orderCount}");
    
                $isComplete = $orderCount >= $target->target;
                $status = $isComplete ? TargetStatusEnum::COMPLETED : TargetStatusEnum::PENDING;
    
                $existingRecord = CallCenterWork::where('user_id', $user->id)
                    ->where('target_id', $target->id)
                    ->where('month', $currentMonth)
                    ->first();
    
                if ($existingRecord) {
                    $this->info("Updating record for user {$user->id} and target category {$category}");
    
                    $existingRecord->order_count = $orderCount;
                    $existingRecord->complete_date = $isComplete ? Carbon::now() : null;
                    $existingRecord->status = $status->value; // Save the integer value of the enum
    
                    $existingRecord->save();
                } else {
                    $this->info("Creating new record for user {$user->id} and target category {$category}");
    
                    CallCenterWork::create([
                        'user_id'       => $user->id,
                        'target_id'     => $target->id,
                        'order_count'   => $orderCount,
                        'month'         => $currentMonth,
                        'complete_date' => $isComplete ? Carbon::now() : null,
                        'status'        => $status->value, // Save the integer value of the enum
                    ]);
                }
            }
        }
    
        \Log::info('CRO work data updated successfully.');
        $this->info('CRO work data updated successfully.');
    }
    
    



    
}
