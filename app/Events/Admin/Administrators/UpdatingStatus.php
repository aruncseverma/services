<?php
/**
 * event triggered when updating admin status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Events\Admin\Administrators;

use App\Models\Administrator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatingStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * user model instance
     *
     * @var App\Models\Administrator
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Administrator $user
     *
     * @return void
     */
    public function __construct(Administrator $user)
    {
        $this->user = $user;
    }
}
