<?php

namespace App\Events\Admin\Members;

use App\Models\Member;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatingStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * user model instance
     *
     * @var App\Models\Member
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Member $user
     *
     * @return void
     */
    public function __construct(Member $user)
    {
        $this->user = $user;
    }
}
