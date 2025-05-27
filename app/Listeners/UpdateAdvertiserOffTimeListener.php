<?php

namespace App\Listeners;

use App\Events\AdvertiserEndWorkEvent;
use App\Models\AdvertiserWork;
use Carbon\Carbon;

class UpdateAdvertiserOffTimeListener
{
    /**
     * Handle the event.
     */
    public function handle(AdvertiserEndWorkEvent $event)
    {
        $today = Carbon::today()->toDateString();
        $offTime = $event->endTime ? Carbon::parse($event->endTime) : null;
        $threshold = Carbon::createFromTimeString('17:30:00');

        $advertiserWork = AdvertiserWork::where('user_id', $event->userId)
            ->where('date', $today)
            ->first();

        if (!$advertiserWork) {
            return;
        }

        if($offTime){
        $completeTime = Carbon::parse($advertiserWork->complete_time);
        $otMinutes = 0;

        if ($offTime->lt($threshold)) {
            $otMinutes = 0;
        } elseif ($completeTime->lt($threshold)) {
            $otMinutes = $threshold->diffInMinutes($offTime, false);
        } else {
            $otMinutes = $completeTime->diffInMinutes($offTime, false);
        }

        $otMinutes = max(0, $otMinutes);

        $advertiserWork->update([
            'off_time' => $offTime,
            'ot' => $otMinutes,
        ]);
    }
    }
}
