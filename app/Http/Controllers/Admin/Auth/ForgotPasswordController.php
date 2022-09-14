<?php
/**
 * controller class for sending an email notification for password reset
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * create instance
     *
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        // set middleware
        $this->middleware('guest:' . $this->getAuthGuardName());
    }

    /**
     * renders view form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view() : View
    {
        $this->setTitle(__('Forgot Password'));

        // disable main wrapper
        $this->disableMainWrapper();

        return view('Admin::auth.forgot_password');
    }

    /**
     * send an email to the user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function send() : RedirectResponse
    {
        $this->validateEmail($this->request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            [
               'email' => $email = $this->request->input('email'),
               'type' => Administrator::USER_TYPE
            ]
        );

        if ($response === Password::RESET_LINK_SENT) {
            $this->notifySuccess(__('An email was sent to <strong>:email</strong>. Please check your inbox', ['email' => $email]));
        } elseif ($response === Password::INVALID_USER) {
            $this->notifyError(__('Email was invalid.'));
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
}
