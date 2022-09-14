<?php

namespace App\Http\Controllers\Admin\Members;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Members\UpdatingStatus;

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

        // update user status
        $user = $this->repository->save(['is_active' => ! $user->isActive()], $user);

        /**
         * trigger event
         *
         * @param App\Models\Member $user
         */
        event(new UpdatingStatus($user));

        $this->notifySuccess(__('Member status updated successfully'));

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
