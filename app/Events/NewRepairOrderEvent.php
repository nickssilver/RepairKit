<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRepairOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $repairOrder, $configs, $admin, $adminConfigs;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($repairOrder, $configs, $admin, $adminConfigs)
    {
        $this->repairOrder = $repairOrder;
        $this->configs = $configs;
        $this->admin = $admin;
        $this->adminConfigs = $adminConfigs;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
