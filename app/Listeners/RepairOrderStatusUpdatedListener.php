<?php

namespace App\Listeners;

use App\Events\RepairOrderStatusUpdatedEvent;
use App\Notifications\Repair\RepairOrderStatusUpdated;

class RepairOrderStatusUpdatedListener
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
     * @param  RepairOrderStatusUpdatedEvent  $event
     * @return void
     */
    public function handle(RepairOrderStatusUpdatedEvent $event)
    {
        $event->repairOrder->notify((new RepairOrderStatusUpdated($event->configs, $event->body))->locale(config('app.locale')));
    }
}
