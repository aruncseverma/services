<?php
/**
 * controller class for updating escort approval status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Escorts\UpdatingApprovalStatus;

class UpdateApprovalController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $isApproved = $this->request->get('is_approved', false);
        $escort     = $this->repository->find($this->request->get('id'));

        // redirect if no user was found
        if (! $escort) {
            $this->notifyError(__('Escort requested not found'));
            return $this->redirectTo();
        }

        // update repository
        $escort = $this->repository->save(['is_approved' => $isApproved], $escort);

        // mark notification as read
        if (!empty($this->request->get('key', ''))) {
            $notification = $this->getAuthUser()->notifications->where('id', $this->request->get('key', ''))->first();
            $notification->markAsRead();
        }

        /**
         * trigger event
         *
         * @param App\Models\Escort
         */
        event(new UpdatingApprovalStatus($escort));

        // notify
        $this->notifySuccess(__('Approval status is updated successfully.'));

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
