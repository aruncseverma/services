<?php
/**
 * update language status controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Languages;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Languages\UpdatingStatus;

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
        $language = $this->repository->find($this->request->input('id'));

        if (! $language) {
            $this->notifyError(__('Language requested does not exists'));
            return redirect()->back();
        }

        // update language status
        $language = $this->repository->save(['is_active' => ! $language->isActive()], $language);

        /**
         * trigger event
         *
         * @param App\Models\Language $language
         */
        event(new UpdatingStatus($language));

        $this->notifySuccess(__('Language status updated successfully'));

        return redirect()->back();
    }
}
