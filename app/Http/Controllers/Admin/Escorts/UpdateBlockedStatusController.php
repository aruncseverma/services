<?php
/**
 * update users block status controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Escorts\UpdatingBlockedStatus;

class UpdateBlockedStatusController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $escort = $this->repository->find($this->request->get('id'));

        // redirect if no user was found
        if (! $escort) {
            $this->notifyError(__('Escort requested not found'));
            return $this->redirectTo();
        }

        // update repository
        $escort = $this->repository->save(
            [
                'is_blocked' => ! $escort->isBlocked(),
                'is_active'  => $escort->isBlocked()
            ],
            $escort
        );

        /**
         * trigger event
         *
         * @param App\Models\Escort
         */
        event(new UpdatingBlockedStatus($escort));

        // notify
        $this->notifySuccess(__('Account status is updated successfully.'));

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
