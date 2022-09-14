<?php

namespace App\Http\Controllers\Admin\Translations;

use Illuminate\Http\RedirectResponse;

class DeleteController extends Controller
{
    /**
     * handles incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(): RedirectResponse
    {
        // notify and redirect if does not have any identifier
        if (!$id = $this->request->input('id')) {
            $this->notifyError(__('Delete requires identifier.'));
            return $this->redirectTo();
        }

        $translation = $this->repository->find($id);
        if (!$translation) {
            $this->notifyError(__('Requested translation not found'));
            return $this->redirectTo();
        }

        // process delete
        if ($this->repository->delete($id)) {
            $this->notifySuccess(__('Delete success.'));
        } else {
            $this->notifyWarning(__('Unable to delete translation. Please try again later'));
        }

        return $this->redirectTo();
    }

    /**
     * get redirect url
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(): RedirectResponse
    {
        return redirect()->back();
    }
}
