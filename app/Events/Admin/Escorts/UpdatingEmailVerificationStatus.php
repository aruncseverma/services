<?php

namespace App\Events\Admin\Escorts;

use App\Models\Escort;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatingEmailVerificationStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * escort model instance
     *
     * @var App\Models\Escort
     */
    public $escort;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Escort $escort
     *
     * @return void
     */
    public function __construct(Escort $escort)
    {
        $this->escort = $escort;
    }
}
