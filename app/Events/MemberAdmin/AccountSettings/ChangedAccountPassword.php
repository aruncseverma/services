<?php
/**
 * event triggered when password changed from account settings
 *
 */

namespace App\Events\MemberAdmin\AccountSettings;

use App\Models\Member;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ChangedAccountPassword
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * member model instance
     *
     * @var App\Models\Member
     */
    public $member;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
