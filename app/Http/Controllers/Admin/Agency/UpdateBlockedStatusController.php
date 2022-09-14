<?php
/**
 * update users block status controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Agency;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Agency\UpdatingBlockedStatus;

class UpdateBlockedStatusController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $agency = $this->repository->find($this->request->get('id'));

        // redirect if no user was found
        if (! $agency) {
            $this->notifyError(__('Escort requested not found'));
            return $this->redirectTo();
        }

        // update repository
        $agency = $this->repository->save(
            [
                'is_blocked' => ! $agency->isBlocked(),
                'is_active'  => $agency->isBlocked()
            ],
            $agency
        );

        /**
         * trigger event
         *
         * @param App\Models\Agency
         */
        event(new UpdatingBlockedStatus($agency));

        // notify
        $this->notifySuccess(__('Account status is updated successfully.'));

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
