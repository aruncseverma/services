<?php

namespace App\Http\Controllers\MemberAdmin\Auth;

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
        return redirect()->route('member_admin.auth.login_form');
    }
}
