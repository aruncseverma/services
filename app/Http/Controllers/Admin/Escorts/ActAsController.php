<?php
/**
 * act as login controller for managing escorts using there account
 * and logged in directly to escort admin
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class ActAsController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $escort = $this->repository->find($this->request->input('id'));

        if (! $escort) {
            $this->notifyError(__('Escort requested does not exists'));
            return $this->redirectTo();
        }

        // login escort through out the application
        $this->getEscortAdminAuthGuard()->login($escort);

        return $this->redirectTo(true);
    }

    /**
     * get escort admin auth guard
     *
     * @return Illuminate\Contracts\Auth\Guard
     */
    protected function getEscortAdminAuthGuard() : Guard
    {
        return app('auth')->guard('escort_admin');
    }

    /**
     * redirect to next request
     *
     * @param  boolean $isSuccess
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(bool $isSuccess = false) : RedirectResponse
    {
        // redirect to escort admin routes
        if ($isSuccess) {
            return redirect()->route('escort_admin.dashboard');
        }

        return redirect()->back();
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:escorts.manage');
    }
}
