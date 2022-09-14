<?php

namespace App\Events\Admin\Notes;

use App\Models\UserNote;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CreatingUserNotes
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * note created instance
     *
     * @var App\Models\UserNote
     */
    public $note;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\UserNote $note
     *
     * @return void
     */
    public function __construct(UserNote $note)
    {
        $this->note = $note;
    }
}
