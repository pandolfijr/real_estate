<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use stdClass;

class EmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $imovel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(stdClass $imovel)
    {
        $this->imovel = $imovel;
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
