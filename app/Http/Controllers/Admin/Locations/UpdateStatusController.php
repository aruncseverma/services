<?php
/**
 * update city status controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Locations;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Locations\UpdatingStatus;

class UpdateStatusController extends Controller
{
    /**
     * handles incoming update request
     *
     * @return void
     */
    public function handle() : RedirectResponse
    {
        // get language model
        $location = $this->repository->find($this->request->input('id'));

        if (! $location) {
            $this->notifyError(__('Location requested does not exists'));
            return redirect()->back();
        }

        // update city status
        $location = $this->repository->save(['is_active' => ! $location->isActive()], $location);

        /**
         * trigger event
         *
         * @param App\Models\City $location
         */
        event(new UpdatingStatus($location));

        $this->notifySuccess(__('Location status updated successfully'));

        return redirect()->back();
    }
}
