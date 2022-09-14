<?php

namespace App\Events\EscortAdmin\File;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UploadFailed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;

    public $error;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $error)
    {
        $this->id = $id;
        $this->error = $error;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['file-channel-' . $this->id];
    }
}