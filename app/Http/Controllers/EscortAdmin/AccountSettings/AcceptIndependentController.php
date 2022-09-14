<?php
/**
 * controller class for accepting invitation request for independent request
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\AccountSettings;

use Carbon\Carbon;
use App\Models\Escort;
use App\Repository\EscortRepository;
use Illuminate\Http\RedirectResponse;
use App\Support\Objects\Concerns\InteractsWithObjects;

class AcceptIndependentController extends Controller
{
    use InteractsWithObjects;

    /**
     * response statuses
     *
     * @const
     */
    const RESPONSE_INVALID_TOKEN   = 'invalid_token';
    const RESPONSE_TOKEN_EXPIRED   = 'expired_token';
    const RESPONSE_MISMATCH_ESCORT = 'mismatch_escort';
    const RESPONSE_CHANGE_SUCCESS  = 'change_success';

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
     * handle incoming request
     *
     * @param  string $token
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle($token) : RedirectResponse
    {
        $response = $this->changeToIndependentEscort($token, $this->getAuthUser());

        switch ($response) {
            case static::RESPONSE_INVALID_TOKEN:
                $this->notifyError(__('Invitation token is invalid'));
                break;
            case static::RESPONSE_TOKEN_EXPIRED:
                $this->notifyError(__('Invitation token is expired'));
                break;
            case static::RESPONSE_MISMATCH_ESCORT:
                $this->notifyError(__('Invitation does not belong to your account'));
                break;
            case static::RESPONSE_CHANGE_SUCCESS:
                $this->notifySuccess(__('Your account was successfully moved to independent'));
                break;
        }

        return redirect()
            ->route('escort_admin.account_settings')
            ->withInput(['notify' => 'switch_account']);
    }

    /**
     * change current escort to independent which will unbind to the agency
     * attached to its account
     *
     * @param  string $token
     * @param  App\Models\Escort $escort
     *
     * @return string
     */
    protected function changeToIndependentEscort($token, Escort $escort) : string
    {
        $payload = $this->fetchObject($token);

        // unknown payload
        if (empty($payload)) {
            return static::RESPONSE_INVALID_TOKEN;
        }

        list($key, $expires) = $payload;

        // checks expiration
        if ($expires < Carbon::now()->getTimestamp()) {
            return static::RESPONSE_TOKEN_EXPIRED;
        }

        if ($escort->getKey() != $key) {
            return static::RESPONSE_MISMATCH_ESCORT;
        }

        // unbind
        $this->escorts->unbindEscortToAgency($escort);

        // delete the object
        $this->deleteObject($token);

        return static::RESPONSE_CHANGE_SUCCESS;
    }
}
