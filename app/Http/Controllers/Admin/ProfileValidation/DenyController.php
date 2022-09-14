<?php
/**
 * controller class for denying profile validation
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\ProfileValidation;

use App\Events\EscortAdmin\Notification\WarnEscort;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Models\UserProfileValidation;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserProfileValidationRepository;

class DenyController extends Controller
{
    /**
     * handle incoming request
     *
     * @param  App\Models\UserProfileValidation $model,
     * @param  Illuminate\Http\Request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(UserProfileValidation $model, Request $request) : RedirectResponse
    {
        $this->validate(
            $request,
            [
                'reason'   => 'required',
            ]
        );

        // deny current model
        $this->repository->save(
            [
                'is_denied' => true,
                'data' => array_merge(
                    $model->data,
                    [
                        'reason' => $reason = $request->input('reason'),
                    ]
                )
            ],
            $model
        );

        // check changes
        if ($model->wasChanged('is_denied')) {
            // send email notification
            $model->user->sendDeniedProfileValidationNotification($reason);

            $message = "<b>Oh no</b> your profile validation request has been denied.";
            event(new WarnEscort($model->user->getKey(), $message));
            $this->notifySuccess(__('Profile Validation denied successfully'));
        } else {
            $this->notifyWarning(__('No changes detected. Please select another one'));
        }

        return back();
    }
}
