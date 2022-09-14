<?php
/**
 * event triggered when email was changed
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Events\EscortAdmin\AccountSettings;

use App\Models\Escort;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ChangedEmailAddress
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
     * @return void
     */
    public function __construct(Escort $escort)
    {
        $this->escort = $escort;
    }
}
