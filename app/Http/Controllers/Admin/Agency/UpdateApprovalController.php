<?php
/**
 * controller class for updating agency approval status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Agency;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Agency\UpdatingApprovalStatus;

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
        $agency     = $this->repository->find($this->request->get('id'));

        // redirect if no user was found
        if (! $agency) {
            $this->notifyError(__('Agency requested not found'));
            return $this->redirectTo();
        }

        // update repository
        $agency = $this->repository->save(['is_approved' => $isApproved], $agency);

        // mark notification as read
        if (!empty($this->request->get('key', ''))) {
            $notification = $this->getAuthUser()->notifications->where('id', $this->request->get('key', ''))->first();
            $notification->markAsRead();
        }

        /**
         * trigger event
         *
         * @param App\Models\Agency
         */
        event(new UpdatingApprovalStatus($agency));

        // notify
        $this->notifySuccess(__('Approval status is updated successfully.'));

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
