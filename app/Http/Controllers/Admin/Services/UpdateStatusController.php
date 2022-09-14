<?php
/**
 * controller class for service update status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UpdateStatusController extends Controller
{
    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $service = $this->repository->find($request->get('id'));

        if (! $service) {
            $this->notifyError(__('Requested service does not exists'));
            return back();
        }

        $this->repository->save(['is_active' => ! $service->isActive()], $service);

        if ($service->wasChanged('is_active')) {
            $this->notifySuccess(__('Status successfully updated'));
        } else {
            $this->notifyWarning(__('No changes detected'));
        }

        return back();
    }
}
