<?php

namespace App\Events\EscortAdmin\AccountSettings;

use App\Models\Escort;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SwitchingAccount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * escort model instance
     *
     * @var App\Models\Escort
     */
    public $escort;

    /**
     * notification response status
     *
     * @var mixed
     */
    public $response;

    /**
     * email of the receiver
     *
     * @var string
     */
    public $email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Escort $escort, string $email, $response)
    {
        $this->escort = $escort;
        $this->email = $email;
        $this->response = $response;
    }
}
