<?php
/**
 * switch account controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\AccountSettings;

use Carbon\Carbon;
use App\Models\Escort;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Repository\AgencyRepository;
use Illuminate\Http\RedirectResponse;
use App\Support\Models\User as RandomUser;
use App\Support\Objects\Concerns\InteractsWithObjects;
use App\Events\EscortAdmin\AccountSettings\SwitchingAccount;

class SwitchAccountController extends Controller
{
    use InteractsWithObjects;

    /**
     * n of days application token will expired
     *
     * @const
     */
    const TOKEN_EXPIRATION_DAYS = 1;

    /**
     * list of notification responses
     *
     * @const
     */
    const RESPONSE_INVALID_AGENCY   = 'invalid_agency';
    const RESPONSE_NOTIFICATION_SENT = 'sent';

    /**
     * create instance
     *
     * @param App\Repository\AgencyRepository $agencyRepository
     */
    public function __construct(AgencyRepository $agencyRepository)
    {
        $this->agencyRepository = $agencyRepository;
    }

    /**
     * handles incoming requests
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $escort = $this->getAuthUser();
        $email  = $request->input('switch_email');

        if (! $this->isEscortHasAgency()) {
            $response = $this->sendEmailNotificationToAgency($escort, $email);
        } else {
            $response = $this->sendEmailNotificationToRandomEmail($escort, $email);
        }

        if ($response === static::RESPONSE_NOTIFICATION_SENT) {
            $this->notifySuccess(__('E-mail has been sent to :email', ['email' => $email]));
        } elseif ($response === static::RESPONSE_INVALID_AGENCY) {
            $this->notifyError(__('Agency E-mail is invalid'));
        } else {
            $this->notifyError(__('Unable to process requests. Please try again sometime'));
        }

        event(new SwitchingAccount($escort, $email, $response));

        return back()->withInput(['notify' => 'switch_account']);
    }

    /**
     * validate request data
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $rules = [
            'required',
            'email',
        ];

        // different rules for switching escort agency and switching to independent
        if (! $this->isEscortHasAgency()) {
            $rules[] = Rule::exists($this->agencyRepository->getTable(), 'email')->where(function ($query) {
                $query->where('type', Agency::USER_TYPE);
                $query->where('is_active', true);
            });
        }

        $this->validate(
            $request,
            [
                'switch_email' => $rules
            ]
        );
    }

    /**
     * checks if current authenticated escort is already an escort agency
     *
     * @return boolean
     */
    protected function isEscortHasAgency() : bool
    {
        return (! is_null($this->getAuthUser()->agency));
    }

    /**
     * send email notification email to agency
     *
     * @param  App\Models\Escort $escort
     * @param  string            $email
     *
     * @return string
     */
    protected function sendEmailNotificationToAgency(Escort $escort, string $email) : string
    {
        $agency = $this->agencyRepository->findBy(['email' => $email]);

        if (! $agency) {
            return static::RESPONSE_INVALID_AGENCY;
        }

        // creates object token with the ff. payload
        $token = $this->createObject([
            $escort->getKey(),
            $agency->getKey(),
            $this->getTokenExpiration(),
        ]);

        // send notification
        $agency->sendEscortAgencyApplicationNotification($token, $escort);

        return static::RESPONSE_NOTIFICATION_SENT;
    }

    /**
     * sents notification to the random user selected by the escort
     * for switching his/her account to independent
     *
     * @param  App\Models\Escort $escort
     * @param  string            $email
     *
     * @return string
     */
    protected function sendEmailNotificationToRandomEmail(Escort $escort, string $email) : string
    {
        // create object token with the ff. payload
        $token = $this->createObject([
            $escort->getKey(),
            $this->getTokenExpiration(),
        ]);

        // create instance of a random user and set the email to the current requested email
        $random = new RandomUser;
        $random->email = $email;

        $random->sendEscortIndependentApplicationNotification($token, $escort);

        return static::RESPONSE_NOTIFICATION_SENT;
    }

    /**
     * get object token expiration timestamp
     *
     * @return integer
     */
    protected function getTokenExpiration() : int
    {
        return Carbon::now()->addDays(static::TOKEN_EXPIRATION_DAYS)->getTimestamp();
    }
}
