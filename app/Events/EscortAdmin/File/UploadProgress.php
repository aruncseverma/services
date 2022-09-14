<?php

namespace App\Events\EscortAdmin\File;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UploadProgress implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;

    public $progress;

    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $progress, $type)
    {
        $this->id = $id;
        $this->type = $type;
        $this->progress = $progress;
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