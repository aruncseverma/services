<?php
/**
 * controller for updating escort email verification status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Escorts\UpdatingEmailVerificationStatus;

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
        $escort     = $this->repository->find($this->request->get('id'));

        // redirect if no user was found
        if (! $escort) {
            $this->notifyError(__('Escort requested not found'));
            return $this->redirectTo();
        }

        // update repository
        $escort = $this->repository->save(
            [
                'is_verified' => $isVerified,
                'is_active'   => $isVerified,
            ],
            $escort
        );

        /**
         * trigger event
         *
         * @param App\Models\Escort
         */
        event(new UpdatingEmailVerificationStatus($escort));

        // notify
        $this->notifySuccess(__('Email verification status is updated successfully.'));

        $this->removeEscortFilterCache();
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
        $this->middleware('can:escorts.manage');
    }
}
