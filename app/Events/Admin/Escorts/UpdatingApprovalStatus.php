<?php
/**
 * event triggered when escort approval is status is being updated
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Events\Admin\Escorts;

use App\Models\Escort;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatingApprovalStatus
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
