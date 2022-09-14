<?php
/**
 * controller class for accepting escort agency application
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Escorts;

use Carbon\Carbon;
use App\Models\Agency;
use App\Repository\EscortRepository;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\AgencyAdmin\Controller;
use App\Support\Objects\Concerns\InteractsWithObjects;
use App\Models\UserActivity;

class AcceptEscortApplicationController extends Controller
{
    use InteractsWithObjects;

    /**
     * default user activity type
     *
     * @const
     */
    const ACTIVITY_TYPE = UserActivity::ESCORT_TYPE;

    /**
     * response statuses
     *
     * @const
     */
    const RESPONSE_INVALID_TOKEN   = 'invalid_token';
    const RESPONSE_TOKEN_EXPIRED   = 'expired_token';
    const RESPONSE_MISMATCH_AGENCY = 'mismatch_agency';
    const RESPONSE_CHANGE_SUCCESS  = 'change_success';
    const RESPONSE_INVALID_ESCORT  = 'invalid_escort';

    /**
     * escorts repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $escorts;

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
     * handles incoming request
     *
     * @param  string $token
     *
     * @return void
     */
    public function handle($token) : RedirectResponse
    {
        $response = $this->processAcceptingApplication($token, $this->getAuthUser());

        switch ($response) {
            case static::RESPONSE_INVALID_TOKEN:
                $this->notifyError(__('Invitation token is invalid'));
                break;
            case static::RESPONSE_MISMATCH_AGENCY:
                $this->notifyError(__('Invitation does not belong to your agency'));
                break;
            case static::RESPONSE_TOKEN_EXPIRED:
                $this->notifyError(__('Invitation is expired'));
                break;
            case static::RESPONSE_INVALID_ESCORT:
                $this->notifyError(__('Escort in the invitation is invalid'));
                break;
            case static::RESPONSE_CHANGE_SUCCESS:
                $this->notifySuccess(__('Escort successfully added to your list of escorts'));
                break;
        }

        // redirect
        return redirect()->route('agency_admin.dashboard');
    }

    /**
     * process accepting the escort application
     *
     * @param  string $token
     *
     * @return string
     */
    protected function processAcceptingApplication($token, Agency $agency) : string
    {
        $payload = $this->fetchObject($token);

        // unknown payload
        if (empty($payload)) {
            return static::RESPONSE_INVALID_TOKEN;
        }

        // parse payload
        list($escort, $agent, $expires) = $payload;

        // not requested agency
        if ($agency->getKey() != $agent) {
            return static::RESPONSE_MISMATCH_AGENCY;
        }

        // checks expiration
        if ($expires < Carbon::now()->getTimestamp()) {
            return static::RESPONSE_TOKEN_EXPIRED;
        }

        // look for the requested escort
        $escort = $this->escorts->find($escort);
        if (! $escort) {
            return static::RESPONSE_INVALID_ESCORT;
        }

        // bind
        $this->escorts->bindEscortToAgency($escort, $agency);

        // delete the object
        $this->deleteObject($token);

        $this->addUserActivity(self::ACTIVITY_TYPE, $escort->getKey(), 'accept_application');

        return static::RESPONSE_CHANGE_SUCCESS;
    }
}
