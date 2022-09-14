<?php
/**
 * delete a administrator controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Administrators;

use Illuminate\Http\RedirectResponse;

class DeleteController extends Controller
{
    /**
     * handles incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        // notify and redirect if does not have any identifier
        if (! $id = $this->request->input('id')) {
            $this->notifyError(__('Delete requires identifier.'));
            return $this->redirectTo();
        }

        // do not allow delete of super admin
        // Note: super admin is treated as 1 and should be the first entry in the database
        if ($id == '1') {
            $this->notifyError(__('Deletion of super admin is not possible. Please select other user.'));
            return $this->redirectTo();
        }

        // process delete
        if ($this->repository->delete($id)) {
            $this->notifySuccess(__('Delete success.'));
        } else {
            $this->notifyWarning(__('Unable to delete user. Please try again later'));
        }

        return $this->redirectTo();
    }

    /**
     * get redirect url
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
        $this->middleware('can:administrators.manage');
    }
}
