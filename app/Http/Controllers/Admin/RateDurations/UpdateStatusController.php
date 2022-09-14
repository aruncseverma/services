<?php
/**
 * controller class for rate duration update status
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\RateDurations;

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
        $duration = $this->durationRepository->find($request->get('id'));

        if (! $duration) {
            $this->notifyError(__('Requested duration does not exists'));
            return back();
        }

        $this->durationRepository->save(['is_active' => ! $duration->isActive()], $duration);

        if ($duration->wasChanged('is_active')) {
            $this->notifySuccess(__('Status successfully updated'));
        } else {
            $this->notifyWarning(__('No changes detected'));
        }

        return back();
    }
}
