<?php

namespace App\Events\Repository\Users;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SavedModelInstance
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * instance of a eloquent model
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * event array of attributes
     *
     * @var array
     */
    public $attributes;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\User $user
     * @param  array           $attributes
     *
     * @return void
     */
    public function __construct(User $user, array $attributes)
    {
        $this->user = $user;
        $this->attributes = $attributes;
    }
}
