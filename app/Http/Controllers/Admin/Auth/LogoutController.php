<?php
/**
 * admin logout controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Auth;

class LogoutController extends Controller
{
    /**
     * handle incoming request
     *
     * @return void
     */
    public function handle()
    {
        // get auth guard
        $auth = $this->getAuthGuard();

        $this->logInfo(
            sprintf('User #%d successfully logged out.', $auth->user()->getKey()),
            [
                'ip' => app('request')->ip(),
            ]
        );

        // logout auth
        $auth->logout();

        return redirect()->route('admin.auth.login_form');
    }
}
