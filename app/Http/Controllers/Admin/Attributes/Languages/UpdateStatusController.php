<?php
/**
 * update attribute status controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Attributes\Languages;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Attributes\UpdatingStatus;

class UpdateStatusController extends Controller
{
    /**
     * handles incoming update request
     *
     * @return void
     */
    public function handle() : RedirectResponse
    {
        // get attribute model
        $attribute = $this->repository->find($this->request->input('id'));

        if (! $attribute) {
            $this->notifyError(__('Attribute requested does not exists'));
            return redirect()->back();
        }

        // update attribute status
        $attribute = $this->repository->save(['is_active' => ! $attribute->isActive()], $attribute);

        /**
         * trigger event
         *
         * @param App\Models\Attribute $attribute
         */
        event(new UpdatingStatus($attribute));

        $this->notifySuccess(__('Attribute status updated successfully'));

        return redirect()->back();
    }
}
