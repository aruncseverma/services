<?php
/**
 * controller for updating agency email verification status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Agency;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Agency\UpdatingEmailVerificationStatus;

class UpdateEmailVerificationStatusController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $isVerified = $this->request->get('is_verified', false);
        $agency     = $this->repository->find($this->request->get('id'));

        // redirect if no user was found
        if (! $agency) {
            $this->notifyError(__('Agency requested not found'));
            return $this->redirectTo();
        }

        // update repository
        $agency = $this->repository->save(
            [
                'is_verified' => $isVerified,
                'is_active'   => $isVerified,
            ],
            $agency
        );

        /**
         * trigger event
         *
         * @param App\Models\Agency
         */
        event(new UpdatingEmailVerificationStatus($agency));

        // notify
        $this->notifySuccess(__('Email verification status is updated successfully.'));

        return $this->redirectTo();
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
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
