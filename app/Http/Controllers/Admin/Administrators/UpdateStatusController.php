<?php
/**
 * update administrator status controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Administrators;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Administrators\UpdatingStatus;

class UpdateStatusController extends Controller
{
    /**
     * handles incoming update request
     *
     * @return void
     */
    public function handle() : RedirectResponse
    {
        // get user model
        $user = $this->repository->find($this->request->input('id'));

        if (! $user) {
            $this->notifyError(__('User requested does not exists'));
            return redirect()->back();
        }

        if ($user->getKey() == config('app.super_admin_user_id') && !$this->isSuperAdmin()) {
            $this->notifyError(__('Permission denied.'));
            return redirect()->back();
        }

        // update user status
        $user = $this->repository->save(['is_active' => ! $user->isActive()], $user);

        /**
         * trigger event
         *
         * @param App\Models\Administrator $user
         */
        event(new UpdatingStatus($user));

        $this->notifySuccess(__('Administrator status updated successfully'));

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
