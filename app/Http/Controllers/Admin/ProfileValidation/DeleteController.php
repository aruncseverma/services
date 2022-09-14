<?php
/**
 * controller class for deleting a specified request information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\ProfileValidation;

use App\Events\EscortAdmin\Notification\WarnEscort;
use Illuminate\Support\Str;
use App\Models\UserProfileValidation;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsStorage;

class DeleteController extends Controller
{
    use NeedsStorage;

    /**
     * handle incoming request
     *
     * @param  App\Models\UserProfileValidation $model
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(UserProfileValidation $model) : RedirectResponse
    {
        // process data information
        $this->deleteData($model->data);

        // delete the model now
        if ($this->repository->delete($model->getKey())) {
            $message = "<b>Oh no</b> your profile validation request has been ignored.";
            event(new WarnEscort($model->user->getKey(), $message));
            $this->notifySuccess(__('Profile validation request was deleted successful'));
        } else {
            $this->notifyError(__('Requested profile validation failed to delete. Please try again sometime'));
        }

        return back();
    }

    /**
     * delete necessary information from the
     *
     * @param  array|null $data
     *
     * @return void
     */
    protected function deleteData(array $data) : void
    {
        // deletes photo path
        foreach ($data as $key => $value) {
            if (Str::contains($key, '_path')) {
                // delete that path
                $fs = $this->getStorage()->disk(substr($key, 0, strrpos($key, '_path')));
                $this->deleteFile($value, $fs);
            }
        }

        // do more here
    }
}
