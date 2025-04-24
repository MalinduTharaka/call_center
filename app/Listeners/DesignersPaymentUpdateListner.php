<?php

namespace App\Listeners;

use App\Events\DesignersPaymentsUpdateEvent;
use App\Models\Order;
use App\Models\PostDesignersWork;
use Carbon\Carbon;

class DesignersPaymentUpdateListner
{
    /**
     * Handle the event.
     */
    public function handle(DesignersPaymentsUpdateEvent $event): void
    {
        $id = $event->id;

        $order = Order::find($id);

        if (!$order) {
            \Log::warning("Order with ID $id not found.");
            return;
        }

        $exists = PostDesignersWork::where('order_id', $order->id)->exists();

        if (!$exists && $order->work_status === 'done' && $order->order_type === 'designs') {
            PostDesignersWork::create([
                'user_id'  => $order->designer_id,
                'order_id' => $order->id,
                'amount'   => optional($order->workType->desidesignPayment)->amount ?? 0,
                'month'    => Carbon::now()->format('F'),
            ]);

            \Log::info("PostDesignersWork created for order ID: {$order->id}");
        } else {
            \Log::info("PostDesignersWork already exists or order status not 'done' for order ID: {$order->id}");
        }
    }
}
