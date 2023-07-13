<?php

namespace App\Listeners;

use App\Events\RepairOrdersAssignedEvent;
use App\Notifications\Repair\RepairOrdersAssigned;

class RepairOrdersAssignedListener
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
     * @param  RepairOrdersAssignedEvent  $event
     * @return void
     */
    public function handle(RepairOrdersAssignedEvent $event)
    {
        $event->repairOrder->user->notify((new RepairOrdersAssigned($event->configs, $event->repairOrder))->locale(config('app.locale')));
    }
}
