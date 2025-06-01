<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        \App\Events\DesignersPaymentsUpdateEvent::class => [
            \App\Listeners\DesignersPaymentUpdateListner::class,
        ],
        \App\Events\AdvertiserWorkEvent::class => [
            \App\Listeners\AdvertiserWorkTableUpdateListner::class,
        ],
         \App\Events\AdvertiserEndWorkEvent::class => [
        \App\Listeners\UpdateAdvertiserOffTimeListener::class,
    ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
