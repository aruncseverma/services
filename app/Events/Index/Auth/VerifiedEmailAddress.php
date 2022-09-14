<?php

/**
 * event triggered when email was verified
 *
 */

namespace App\Events\Index\Auth;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class VerifiedEmailAddress
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * user model instance
     *
     * @var App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(user $user)
    {
        $this->user = $user;
    }
}
