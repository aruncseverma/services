<?php
/**
 * controller class for recovering escort account which is being deleted
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use App\Models\Escort;
use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Escorts\RestoredUserAccount;
use App\Repository\AccountDeletionRequestRepository;

class RecoverAccountDeletedController extends Controller
{
    /**
     * handles incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $escort = $this->repository->find($this->request->get('id'));

        if (! $escort) {
            $this->notifyError(__('User requested not found'));
            return back();
        }

        if (! $escort->trashed()) {
            $this->notifyWarning(__('User was not been deleted. Please select another'));
            return back();
        }

        if ($this->restoreAccount($escort)) {
            $this->notifySuccess(__('User restored successfully'));
            $this->removeEscortFilterCache();
        } else {
            $this->notifyError(__('Unable to restore user. Please try again sometime'));
        }

        return back();
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

    /**
     * restores user account
     *
     * @param  App\Models\Escort $escort
     *
     * @return boolean
     */
    protected function restoreAccount(Escort $escort) : bool
    {
        // removes deleted_at value then deletes the request attached to the user
        if ($restored = $this->repository->restore($escort)) {
            // get repository and delete record through repository
            $repository = app(AccountDeletionRequestRepository::class);
            $repository->delete($escort->deletionRequest->getKey());

            // logs request
            $this->logInfo(
                sprintf('User #%d was restored by #%d', $escort->getKey(), $this->getAuthUser()->getKey()),
                [
                    'ip' => $this->request->ip()
                ]
            );
        }

        /**
         * trigger event
         *
         * @param App\Models\Escort $escort
         * @param bool              $restored
         */
        event(new RestoredUserAccount($escort, $restored));

        return $restored;
    }
}
