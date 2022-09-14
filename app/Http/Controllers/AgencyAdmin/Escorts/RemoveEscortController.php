<?php
/**
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Escorts;

use App\Models\Escort;
use App\Repository\EscortRepository;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\AgencyAdmin\Controller;
use App\Models\UserActivity;

class RemoveEscortController extends Controller
{
    /**
     * default user activity type
     *
     * @const
     */
    const ACTIVITY_TYPE = UserActivity::ESCORT_TYPE;

    /**
     * create instance
     *
     * @param App\Repository\EscortRepository $escorts
     */
    public function __construct(EscortRepository $escorts)
    {
        parent::__construct();
        $this->escorts = $escorts;
    }

    /**
     * handle incoming request
     *
     * @param  App\Models\Escort $escort
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Escort $escort) : RedirectResponse
    {
        $agency = $this->getAuthUser();

        // if current escort does not attached to any agency
        if (empty($escort->agency)) {
            $this->notifyError(__('Selected escort does not have any agency attached'));
            return $this->redirectTo();
        }

        // if current agency of the selected escort does not matched with the current
        // authenticated agency
        if ($agency->getKey() != $escort->agency->getKey()) {
            $this->notifyError(__('Escort does not belong to your agency'));
            return $this->redirectTo();
        }

        // proceed remove
        $this->escorts->unbindEscortToAgency($escort);

        // notify
        $this->notifySuccess(__('Escort removed successfully from your escorts list'));

        $this->addUserActivity(self::ACTIVITY_TYPE, $escort->getKey(), 'remove');

        return $this->redirectTo();
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        return redirect()->back();
    }
}
