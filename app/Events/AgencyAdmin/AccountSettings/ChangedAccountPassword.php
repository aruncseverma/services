<?php
/**
 * event triggered when password changed from account settings
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Events\AgencyAdmin\AccountSettings;

use App\Models\Agency;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ChangedAccountPassword
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
     * @return void
     */
    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }
}
