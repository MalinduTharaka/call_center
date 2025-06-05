<?php

namespace App\Console\Commands;

use App\Enums\TargetStatusEnum;
use App\Models\CallCenterWork;
use App\Models\Order;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CroTargetUpdateSchedule extends Command
{
    protected $signature = 'app:cro-target';
    protected $description = 'Updates CRO target progress monthly';

    public function handle()
    {
        Log::info('CroTargetUpdateSchedule started.');

        $users = User::where('role', 'cro')->get();
        Log::info('Users fetched.', ['count' => $users->count()]);

        if ($users->isEmpty()) {
            Log::warning('No CRO users found.');
            return;
        }

        $currentMonth = Carbon::now()->startOfMonth()->toDateString();

        $targets = Target::where('user_role', 'cro')
            ->whereIn('target_category', ['video', 'boosting'])
            ->get()
            ->keyBy('target_category');

        foreach ($users as $user) {
            foreach (['video', 'boosting'] as $category) {
                $target = $targets->get($category);

                if (!$target) {
                    Log::warning("No target found for category '{$category}'.");
                    continue;
                }

                $orderCount = Order::where('uid', $user->id)
                    ->where('ps', 1)
                    ->where('service', '>', 0)
                    ->where('order_type', $category)
                    ->whereMonth('created_at', Carbon::parse($currentMonth)->month)
                    ->whereYear('created_at', Carbon::parse($currentMonth)->year)
                    ->count();


                Log::info("User {$user->id} | Category: {$category} | Order Count: {$orderCount}");

                $isComplete = $orderCount >= $target->target;
                $status = $isComplete ? TargetStatusEnum::COMPLETED : TargetStatusEnum::PENDING;

                $existingRecord = CallCenterWork::where('user_id', $user->id)
                    ->where('target_id', $target->id)
                    ->where('month', $currentMonth)
                    ->first();

                if ($existingRecord) {
                    Log::info("Updating record for user {$user->id} and category {$category}.");

                    $existingRecord->update([
                        'order_count' => $orderCount,
                        'complete_date' => $isComplete ? Carbon::now() : null,
                        'status' => $status->value,
                    ]);
                } else {
                    Log::info("Creating new record for user {$user->id} and category {$category}.");

                    CallCenterWork::create([
                        'user_id' => $user->id,
                        'target_id' => $target->id,
                        'order_count' => $orderCount,
                        'month' => $currentMonth,
                        'complete_date' => $isComplete ? Carbon::now() : null,
                        'status' => $status->value,
                    ]);
                }
            }
        }

        Log::info('CroTargetUpdateSchedule completed successfully.');
    }
}
