<?php
/**
 * event triggered when updating agency block status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Events\Admin\Agency;

use App\Models\Agency;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatingBlockedStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * agency model instance
     *
     * @var App\Models\Agency
     */
    public $agency;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Agency $agency
     *
     * @return void
     */
    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }
}
