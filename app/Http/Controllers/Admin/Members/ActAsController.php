<?php

namespace App\Http\Controllers\Admin\Members;

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
        $member = $this->repository->find($this->request->input('id'));

        if (! $member) {
            $this->notifyError(__('Agency requested does not exists'));
            return $this->redirectTo();
        }

        // login member through out the application
        $this->getMemberAdminAuthGuard()->login($member);

        return $this->redirectTo(true);
    }

    /**
     * get member admin auth guard
     *
     * @return Illuminate\Contracts\Auth\Guard
     */
    protected function getMemberAdminAuthGuard() : Guard
    {
        return app('auth')->guard('member_admin');
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
            return redirect()->route('member_admin.dashboard');
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
        $this->middleware('can:members.manage');
    }
}
