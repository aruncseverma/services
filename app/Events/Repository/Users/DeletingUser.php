<?php

namespace App\Events\Repository\Users;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class DeletingUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * result of delete
     *
     * @var boolean
     */
    public $result = false;

    /**
     * user model instance
     *
     * @var App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  bool            $result
     * @param  App\Models\User $user
     *
     * @return void
     */
    public function __construct(bool $result, User $user)
    {
        $this->result = $result;
        $this->user   = $user;
    }
}
