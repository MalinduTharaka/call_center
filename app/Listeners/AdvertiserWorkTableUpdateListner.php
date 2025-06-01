<?php

namespace App\Listeners;

use App\Events\AdvertiserWorkEvent;
use App\Models\AdvertiserWork;
use App\Models\Order;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdvertiserWorkTableUpdateListner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AdvertiserWorkEvent $event): void
    {
        \Log::info('AdvertiserWorkEvent triggered', ['event_id' => $event->id]);

        $id = $event->id;
        $order = Order::find($id);

        if (!$order) {
            \Log::warning('Order not found for event ID', ['event_id' => $id]);
            return;
        }

        \Log::info('Order found', ['order_id' => $order->id, 'work_status' => $order->work_status, 'advertiser_id' => $order->advertiser_id]);

        if (
            $order->work_status !== 'done' ||
            empty($order->advertiser_id)
        ) {
            \Log::info('Order does not meet criteria for advertiser work update.', [
                'work_status' => $order->work_status,
                'advertiser_id' => $order->advertiser_id,
            ]);
            return;
        }

        $advertiserId = $order->advertiser_id;
        $today        = Carbon::today();
        $now          = Carbon::now();

        // Count today's completed orders for this advertiser
        $completedCount = Order::query()
            ->where('advertiser_id', $advertiserId)
            ->where('work_status', 'done')
            ->whereDate('due_date', $today)
            ->count();

        \Log::info('Completed orders count fetched', ['completed_count' => $completedCount, 'advertiser_id' => $advertiserId, 'date' => $today]);

        // Grab or instantiate today's AdvertiserWork row
        $work = AdvertiserWork::firstOrNew([
            'user_id' => $advertiserId,
            'date'    => $today,
        ]);

        if (! $work->exists) {
            \Log::info('Creating new AdvertiserWork row for today.');

            $targetRow = Target::query()
                ->where('user_role', 'advertiser')
                ->where('target_type', 'daily')
                ->where('target_category', 'boosting')
                ->first();

            $work->target = $targetRow ? $targetRow->target : 0;

            \Log::info('Target fetched', ['target' => $work->target]);
        }

        $work->add_count = $completedCount;

        if (is_null($work->complete_time) && $completedCount >= $work->target) {
            $work->complete_time = $now;
            \Log::info('Target met. complete_time set.', ['complete_time' => $now]);
        }

        $work->save();

        \Log::info('AdvertiserWork saved successfully.', [
            'user_id' => $advertiserId,
            'date' => $today,
            'add_count' => $work->add_count,
            'complete_time' => $work->complete_time,
        ]);
    }
}
