<?php

namespace App\Listeners;

use App\Events\NewRepairOrderEvent;
use App\Notifications\Repair\NewRepairOrderAlertToAdmin;

class NewRepairOrderForAdminListener
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
        $event->admin->notify((new NewRepairOrderAlertToAdmin($event->adminConfigs, $event->repairOrder))
                ->locale(config('app.locale')));
    }
}
