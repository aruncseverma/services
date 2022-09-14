<?php

namespace App\Http\Controllers\Admin\Administrators;

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
        $admin = $this->repository->find($this->request->input('id'));

        if (!$admin || $admin->getKey() == 1) {
            $this->notifyError(__('Administrator requested does not exists'));
            return $this->redirectTo();
        }

        if (!$this->isSuperAdmin()) {
            $this->notifyError(__('Only super admin allow to act as behalf other administrators.'));
            return $this->redirectTo();
        }

        // login admin through out the application
        $this->getAdminAuthGuard()->login($admin);

        return $this->redirectTo(true);
    }

    /**
     * get admin auth guard
     *
     * @return Illuminate\Contracts\Auth\Guard
     */
    protected function getAdminAuthGuard() : Guard
    {
        return app('auth')->guard('admin');
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
        // redirect to admin routes
        if ($isSuccess) {
            return redirect()->route('admin.dashboard');
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
        $this->middleware('can:administrators.manage');
    }
}
