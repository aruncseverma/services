<?php
/**
 * event triggered when escort account is restored
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Events\Admin\Escorts;

use App\Models\Escort;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RestoredUserAccount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * escort model instance
     *
     * @var App\Models\Escort
     */
    public $escort;

    /**
     * status of restoration
     *
     * @var bool
     */
    public $restored;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\Escort $escort
     *
     * @return void
     */
    public function __construct(Escort $escort, bool $restored)
    {
        $this->escort = $escort;
        $this->restored = $restored;
    }
}
