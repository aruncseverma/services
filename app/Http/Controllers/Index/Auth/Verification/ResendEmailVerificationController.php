<?php

namespace App\Http\Controllers\Index\Auth\Verification;

use App\Http\Controllers\Index\Auth\BaseVerificationController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use App\Models\User;

class ResendEmailVerificationController extends BaseVerificationController
{
    /**
     * request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * users model instance
     *
     * @var App\Models\User
     */
    protected $model;

    /**
     * create instance
     *
     * @param Request $request
     * @param User $model
     */
    public function __construct(Request $request, User $model)
    {
        $this->request = $request;
        $this->model = $model;

        // set middleware
        //$this->middleware('guest:' . $this->getAuthGuardName());
    }

    /**
     * renders resend view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function renderForm(): View
    {
        // set title
        $this->setTitle(__('Email Verification'));

        // disable main wrapper
        $this->disableMainWrapper();

        return view('Index::auth.verification.resend');
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(): RedirectResponse
    {
        // validate request
        $this->validateRequest();

        // get user
        $user = $this->model->where('email', $this->request->email)->first();
        if (!$user) {
            $this->notifyError(__('Unable to process your request. Please try again'));
            return redirect()->back();
        }

        // check if user is alreadr verified
        if ($user->isEmailVerified()) {
            $this->notifyError(__('Email address has already been verified.'));
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
        $exists = Rule::exists($this->model->getTable());
        $rules = [
            'email'            => ['required', 'email', $exists],
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules
        );
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
        return redirect()->back();
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
    // public function getAuthGuardName(): string
    // {
    //     return 'escort_admin';
    // }
}
