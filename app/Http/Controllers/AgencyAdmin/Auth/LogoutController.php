<?php
/**
 * admin logout controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Auth;

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
        return redirect()->route('agency_admin.auth.login_form');
    }
}
