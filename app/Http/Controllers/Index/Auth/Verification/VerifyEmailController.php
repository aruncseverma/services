<?php
/**
 * controller class for verifying token given for verifying email request done by
 * the user
 *
 */

namespace App\Http\Controllers\Index\Auth\Verification;

use App\Http\Controllers\Index\Auth\Controller;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Support\Objects\Concerns\InteractsWithObjects;
use App\Events\Index\Auth\VerifiedEmailAddress;
use Illuminate\Contracts\View\View;

class VerifyEmailController extends Controller
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
     * user model instance
     *
     * @var App\Models\User
     */
    protected $model;

    /**
     * create instance
     *
     * @param App\Models\User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * renders notice view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function renderNotice(): View
    {
        // set title
        $this->setTitle(__('Email Verification'));

        // disable main wrapper
        $this->disableMainWrapper();

        return view('Index::auth.verification.verify');
    }

    /**
     * handles incoming request for changing email request using token
     *
     * @param  string $token
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle($token): RedirectResponse
    {
        $response = $this->processEmailVerificationRequest($token);

        if ($response === static::RESPONSE_INVALID_TOKEN) {
            $this->notifyError(__('Invalid token provided'));
        } elseif ($response === static::RESPONSE_TOKEN_EXPIRED) {
            $this->notifyError(__('Token provided is already expired.'));
        } elseif ($response === static::RESPONSE_INVALID_USER) {
            $this->notifyError(__('Invalid user attached to the token provided'));
        } else {
            $this->notifySuccess(__('Your e-mail is verified. You can now login.'));
        }

        return redirect()->route('index.auth.login_form');
    }

    /**
     * process change email request using token
     *
     * @param  string $token
     *
     * @return string
     */
    protected function processEmailVerificationRequest($token): string
    {
        $payload = $this->fetchObject($token);

        if (!$payload) {
            return static::RESPONSE_INVALID_TOKEN;
        }

        // get payload information
        list($id, $email, $expires) = $payload;

        // checks expiration
        if ($expires < Carbon::now()->getTimestamp()) {
            return static::RESPONSE_TOKEN_EXPIRED;
        }

        // checks user
        $user = $this->model->find($id);

        if (!$user) {
            return static::RESPONSE_INVALID_USER;
        }

        // checks email
        if ($email !== $user->email) {
            return static::RESPONSE_INVALID_USER;
        }

        // update the email
        $user->email_verified_at = Carbon::now();
        $user->save();

        // delete the object
        $this->deleteObject($token);

        /**
         * trigger event
         *
         * @param App\Models\User $user
         */
        event(new VerifiedEmailAddress($user));

        return static::RESPONSE_CHANGE_SUCCESS;
    }
}
