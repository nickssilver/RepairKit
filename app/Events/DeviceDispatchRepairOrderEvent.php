<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeviceDispatchRepairOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $repairOrder, $configs;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($repairOrder, $configs)
    {
        $this->repairOrder = $repairOrder;
        $this->configs = $configs;
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
