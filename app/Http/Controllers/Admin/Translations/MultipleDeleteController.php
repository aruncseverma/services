<?php

namespace App\Http\Controllers\Admin\Translations;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MultipleDeleteController extends Controller
{
    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $ids = $request->input('ids');
        if (!$ids) {
            $this->notifyError(__('No data to delete'));
            return back();
        }

        // save
        $affected = $this->repository->multipleDelete($ids);

        // redirect to next request
        if (!$affected) {
            $this->notifyWarning(__('Unable to delete translation. Please try again later'));
        } else {
            $this->notifySuccess(__('Translations successfully deleted.'));
        }

        return back();
    }
}
