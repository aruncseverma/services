<?php

namespace App\Events\EscortAdmin\File;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UploadStart implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function broadcastOn()
    {
        return ['file-channel-' . $this->id];
    }
}