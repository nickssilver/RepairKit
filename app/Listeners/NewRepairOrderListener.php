<?php

namespace App\Listeners;

use App\Events\NewRepairOrderEvent;
use App\Notifications\Repair\NewRepairOrder;

class NewRepairOrderListener
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
     * @param  NewRepairOrderEvent  $event
     * @return void
     */
    public function handle(NewRepairOrderEvent $event)
    {
        $event->repairOrder->notify((new NewRepairOrder($event->configs))->locale(config('app.locale')));
    }
}
