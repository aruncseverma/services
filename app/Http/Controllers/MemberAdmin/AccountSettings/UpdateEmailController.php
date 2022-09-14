<?php
/**
 * update user email with verification on account settings.
 *
 */

namespace App\Http\Controllers\MemberAdmin\AccountSettings;

use Carbon\Carbon;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Repository\MemberRepository;
use Illuminate\Http\RedirectResponse;
use App\Support\Objects\Concerns\InteractsWithObjects;

class UpdateEmailController extends Controller
{
    use InteractsWithObjects;

    /**
     * no of hours token will expire
     *
     * @const
     */
    const TOKEN_EXPIRATION_HOURS = 1;

    /**
     * response statuses
     *
     * @const
     */
    const RESPONSE_EMAIL_SENT     = 'email_sent';
    const RESPONSE_FAILED_TOKEN   = 'token_failed';

    /**
     * agency repository instance
     *
     * @var App\Repository\MemberRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\MemberRepository $repository
     */
    public function __construct(MemberRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $auth = $this->getAuthUser();
        $email = $request->input('change_email');

        if ($auth->email === $email) {
            $this->notifyError(__('strings.change_email_same'));
            return back()->withInput(['notify' => 'change_email']);
        }

        $response = $this->sendChangeEmailNotification($email, $auth);

        if ($response === static::RESPONSE_EMAIL_SENT) {
            $this->notifySuccess(__('Email has been sent to :email. Kindly check your mail', ['email' => $email]));
        } elseif ($response === static::RESPONSE_FAILED_TOKEN) {
            $this->notifyError(__('Request token failed to generate. Please try again'));
        } else {
            $this->notifyError(__('Unable to process your request. Please try again'));
        }

        return back()->withInput(['notify' => 'change_email']);
    }

    /**
     * validates incoming request
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'change_email' => [
                    'required',
                    'email',
                    Rule::unique($this->repository->getTable(), 'email')->ignoreModel($this->getAuthUser())
                ]
            ]
        );
    }

    /**
     * sends change email notification to new email
     *
     * @param  string            $email
     * @param  App\Models\Member $user
     *
     * @return string
     */
    protected function sendChangeEmailNotification(string $email, Member $user) : string
    {
        $payload = [
            $user->getKey(),
            $email,
            Carbon::now()->addHours(static::TOKEN_EXPIRATION_HOURS)->getTimestamp(),
        ];

        $token = $this->createObject($payload);

        if (! $token) {
            return static::RESPONSE_FAILED_TOKEN;
        }

        // temporary change the user email for notification
        // and send notification to that email
        $user->setAttribute('email', $email);

        $user->sendChangeEmailNotification($token);

        return static::RESPONSE_EMAIL_SENT;
    }
}
