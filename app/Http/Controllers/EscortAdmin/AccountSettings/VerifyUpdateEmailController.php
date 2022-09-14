<?php
/**
 * controller class for verifying token given for updating email request done by
 * the escort
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\AccountSettings;

use Carbon\Carbon;
use App\Models\Escort;
use App\Repository\EscortRepository;
use Illuminate\Http\RedirectResponse;
use App\Support\Objects\Concerns\InteractsWithObjects;
use App\Events\EscortAdmin\AccountSettings\ChangedEmailAddress;

class VerifyUpdateEmailController extends Controller
{
    use InteractsWithObjects;

    /**
     * response statuses
     *
     * @const
     */
    const RESPONSE_INVALID_TOKEN  = 'invalid_token';
    const RESPONSE_TOKEN_EXPIRED  = 'expired_token';
    const RESPONSE_INVALID_USER   = 'invalid_user';
    const RESPONSE_CHANGE_SUCCESS = 'change_success';

    /**
     * escort repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\EscortRepository $repository
     */
    public function __construct(EscortRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * handles incoming request for changing email request using token
     *
     * @param  string $token
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function index($token) : RedirectResponse
    {
        $response = $this->processChangeEmailRequest($token, $this->getAuthUser());

        if ($response === static::RESPONSE_INVALID_TOKEN) {
            $this->notifyError(__('Invalid token provided'));
        } elseif ($response === static::RESPONSE_TOKEN_EXPIRED) {
            $this->notifyError(__('Token provided is already expired.'));
        } elseif ($response === static::RESPONSE_INVALID_USER) {
            $this->notifyError(__('Invalid user attached to the token provided'));
        } else {
            $this->notifySuccess(__('E-mail Address updated successfully'));
        }

        return redirect()
            ->route('escort_admin.account_settings')
            ->withInput(['notify' => 'change_email']);
    }

    /**
     * process change email request using token
     *
     * @param  string $token
     * @param  Escort $user
     *
     * @return string
     */
    protected function processChangeEmailRequest($token, Escort $user) : string
    {
        $payload = $this->fetchObject($token);

        if (! $payload) {
            return static::RESPONSE_INVALID_TOKEN;
        }

        // get payload information
        list($id, $email, $expires) = $payload;

        // checks expiration
        if ($expires < Carbon::now()->getTimestamp()) {
            return static::RESPONSE_TOKEN_EXPIRED;
        }

        // checks id
        if ($id !== $user->getKey()) {
            return static::RESPONSE_INVALID_USER;
        }

        // update the email
        $this->repository->save(['email' => $email], $user);

        // delete the object
        $this->deleteObject($token);

        /**
         * trigger event
         *
         * @param App\Models\Escort
         */
        event(new ChangedEmailAddress($user));

        return static::RESPONSE_CHANGE_SUCCESS;
    }
}
