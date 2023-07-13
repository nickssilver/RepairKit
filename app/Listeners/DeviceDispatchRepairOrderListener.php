<?php

namespace App\Listeners;

use App\Events\DeviceDispatchRepairOrderEvent;
use App\Notifications\Repair\DeviceDispatchRepairOrder;

class DeviceDispatchRepairOrderListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DeviceDispatchRepairOrderEvent  $event
     * @return void
     */
    public function handle(DeviceDispatchRepairOrderEvent $event)
    {
        $event->repairOrder->notify((new DeviceDispatchRepairOrder($event->configs))->locale(config('app.locale')));
    }
}
