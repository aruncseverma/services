<?php
/**
 * admin login controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Index\Auth;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
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
     * renders login view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        // set title
        $this->setTitle(__('Login'));

        // disable main wrapper
        $this->disableMainWrapper();

        return view('Index::auth.login', [
            'redirectUrl' => $this->request->get('redirect_url')
        ]);
    }

    /**
     * attemps to authenticate given credentials
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $this->validateRequest();

        $auth = $this->getAuthGuard();

        // get credentials
        $credentials = [
            'email'     => $this->request->input('email'),
            'password'  => $this->request->input('password'),
            'is_active' => true,
            'type'      => Member::USER_TYPE
        ];

        // attempt to login
        if ($auth->attempt($credentials)) {
            $this->logInfo(
                sprintf('User #%d successfully logged in.', $auth->user()->getKey()),
                [
                    'ip' => $this->request->ip(),
                ]
            );

            // redirect to next action
            return $this->redirectTo();
        }

        // notify error
        $this->notifyError(__('Invalid credentials provided.'));
        // log action
        $this->logInfo(
            'User failed to logged in.',
            [
                'ip' => $this->request->ip(),
                'email' => $this->request->input('email')
            ]
        );

        return redirect()->back();
    }

    /**
     * validates incoming request
     *
     * @throw Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest() : void
    {
        $this->validate(
            $this->request,
            [
                'email' => 'required',
                'password' => 'required',
            ]
        );
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        if ($this->request->filled('redirect_url')) {
            return redirect($this->request->get('redirect_url'));
        }

        return redirect()->route('index.home');
    }
}
