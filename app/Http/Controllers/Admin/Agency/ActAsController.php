<?php
/**
 * act as login controller for managing agency using there account
 * and logged in directly to escort admin
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Agency;

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
        $agency = $this->repository->find($this->request->input('id'));

        if (! $agency) {
            $this->notifyError(__('Agency requested does not exists'));
            return $this->redirectTo();
        }

        // login agency through out the application
        $this->getAgencyAdminAuthGuard()->login($agency);

        return $this->redirectTo(true);
    }

    /**
     * get agency admin auth guard
     *
     * @return Illuminate\Contracts\Auth\Guard
     */
    protected function getAgencyAdminAuthGuard() : Guard
    {
        return app('auth')->guard('agency_admin');
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
            return redirect()->route('agency_admin.dashboard');
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
        $this->middleware('can:agency.manage');
    }
}
