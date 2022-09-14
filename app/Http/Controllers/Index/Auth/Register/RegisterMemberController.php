<?php

namespace App\Http\Controllers\Index\Auth\Register;

use App\Http\Controllers\Index\Auth\BaseVerificationController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Repository\UserRepository;
use App\Models\UserLocation;
use App\Repository\UserLocationRepository;
use App\Models\Member;

class RegisterMemberController extends BaseVerificationController
{
    /**
     * default type
     *
     * @const
     */
    const DEFAULT_TYPE = Member::USER_TYPE;

    /**
     * request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * users repository instance
     *
     * @var App\Repository\UserRepository
     */
    protected $repository;

    /**
     * users location repository instance
     *
     * @var App\Repository\UserLocationRepository
     */
    protected $locations;

    /**
     * create instance
     *
     * @param Request $request
     * @param UserRepository $repository
     * @param UserLocationRepository $locations
     */
    public function __construct(
        Request $request, 
        UserRepository $repository,
        UserLocationRepository $locations)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->locations = $locations;

        // set middleware
        $this->middleware('guest:' . $this->getAuthGuardName());
    }

    /**
     * renders register view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function renderForm(): View
    {
        // set title
        $this->setTitle(__('Member Register'));

        // disable main wrapper
        $this->disableMainWrapper();

        return view('Index::auth.register.member_form');
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(): RedirectResponse
    {
        // validate request if passed then proceeds to saving user info
        $this->validateRequest();

        // save user
        $user = $this->saveUser();

        // save user location
        $this->saveLocation($user);
    
        if (!$user) {
            $this->notifyError(__('Unable to process your request. Please try again'));
            return redirect()->back();
        }

        $response = $this->sendEmailVerificationNotification($user);

        if ($response === static::RESPONSE_EMAIL_SENT) {
            $this->notifySuccess(__('We sent you an activation code. Check your email and click on the link to verify.'));
        } elseif ($response === static::RESPONSE_FAILED_TOKEN) {
            $this->notifyError(__('Request token failed to generate. Please try again'));
        } else {
            $this->notifyError(__('Unable to process your request. Please try again'));
        }

        return $this->redirectTo($user);
    }

    /**
     * validate incoming request
     *
     * @return void
     */
    protected function validateRequest(): void
    {
        $unique = Rule::unique($this->repository->getTable());
        $rules = [
            'email'                 => ['required', 'email', $unique],
            'username'              => ['required', $unique],
            'password'              => ['required', 'min:6'],
            'confirm_password'      => ['same:password'],
            'name'                  => 'required',
            //'gender'                => ['required'],
            'continent'    => ['required', 'continents'],
            'country'      => ['required', 'countries'],
            'state'        => ['required', 'states'],
            'city'         => ['required', 'cities'],
            'terms' => 'required',
            'g-recaptcha-response' => 'required|google_recaptcha'
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules,
            [],
            ['g-recaptcha-response' => 'Recaptcha']
        );
    }

    /**
     * save user data
     *
     * @return App\Models\User
     */
    protected function saveUser(): User
    {
        $attributes = [
            'email'     => $this->request->input('email'),
            'username'  => $this->request->input('username'),
            'password'      => $this->request->input('password'),
            'name'      => $this->request->input('name'),
            'is_active' => true,
            'type'      => self::DEFAULT_TYPE,
            'is_newsletter_subscriber'      => $this->request->input('is_newsletter_subscriber') ?? 0,
            
            'gender'      => $this->request->input('gender'),
            'phone'      => $this->request->input('phone'),
        ];

        // save to repository
        $user = $this->repository->save($attributes);

        return $user;
    }

    /**
     * redirect to next route
     *
     * @param  App\Models\User $user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(User $user): RedirectResponse
    {
        //return redirect()->route('escort_admin.auth.login_form');
        return redirect()->route('index.verification.notice');
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        //
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getAuthGuardName(): string
    {
        return 'member_admin';
    }

    /**
     * save location information
     *
     * @param  App\Models\User       $user
     *
     * @return App\Models\UserLocation
     */
    protected function saveLocation(User $user): UserLocation
    {
        // save locations request
        $location = $this->locations->store(
            [
                'type' => UserLocation::MAIN_LOCATION_TYPE,
                'continent_id' => $this->request->continent,
                'country_id' => $this->request->country,
                'state_id' => $this->request->state,
                'city_id' => $this->request->city,
            ],
            $user
        );

        return $location;
    }
}
