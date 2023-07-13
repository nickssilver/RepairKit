<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\NewRepairOrderEvent' => [
            'App\Listeners\NewRepairOrderListener',
            'App\Listeners\NewRepairOrderForAdminListener',
        ],
        'App\Events\RepairOrdersAssignedEvent' => [
            'App\Listeners\RepairOrdersAssignedListener',
        ],
        'App\Events\RepairOrderStatusUpdatedEvent' => [
            'App\Listeners\RepairOrderStatusUpdatedListener',
        ],
        'App\Events\DeviceDispatchRepairOrderEvent' => [
            'App\Listeners\DeviceDispatchRepairOrderListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
