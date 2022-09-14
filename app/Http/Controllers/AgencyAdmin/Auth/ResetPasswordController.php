<?php
/**
 * sends and resets password of user selected
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Auth;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Repository\AgencyRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * repository instance
     *
     * @var App\Repository\AgencyRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Request $request, AgencyRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        // set middleware
        $this->middleware('guest:' . $this->getAuthGuardName());
    }

    /**
     * to be called when user visited the link
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view() : View
    {
        $this->setTitle(__('Reset Password'));

        // disable main wrapper
        $this->disableMainWrapper();

        return view('Admin::auth.reset_password', ['token' => $this->request->get('_token')]);
    }

    /**
     * handle reset request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $this->validateRequest();

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($this->request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            $this->notifySuccess(__('Password reset successfully'));
            return redirect()->route('admin.auth.profile_form');
        } elseif ($response === Password::INVALID_TOKEN) {
            $this->notifyError(__('Invalid token provided'));
        } elseif ($response === Password::INVALID_PASSWORD) {
            $this->notifyError(__('Invalid password provided'));
        } elseif ($response === Password::INVALID_USER) {
            $this->notifyError(__('Invalid password provided'));
        } else {
            $this->notifyError(__('Unknown error has occured'));
        }

        return back();
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker() : PasswordBroker
    {
        return Password::broker('admin');
    }

    /**
     * {@inheritDoc}
     */
    protected function resetPassword($user, $password) : void
    {
        $user = $this->repository->save(
            [
                'password' => $password,
            ],
            $user
        );

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            [
                'type' => Agency::USER_TYPE
            ]
        );
    }

    /**
     * {@inheritDoc}
     *
     * @return Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() : StatefulGuard
    {
        return $this->getAuthGuard();
    }

    /**
     * validate incoming request
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest() : void
    {
        $this->validate(
            $this->request,
            [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ]
        );
    }
}
