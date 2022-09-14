<?php
/**
 * admin logout controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Auth;

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

        // logout auth
        $auth->logout();

        // redirects to login form
        return redirect()->route('escort_admin.auth.login_form');
    }
}
