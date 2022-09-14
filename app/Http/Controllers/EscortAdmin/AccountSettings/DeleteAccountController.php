<?php
/**
 * delete account request controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\AccountSettings;

use App\Events\Admin\Notification\WarnAdmin;
use Illuminate\Http\Request;
use App\Models\AccountDeletionRequest;
use App\Notifications\Admin\User\DeactivateEscort;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AccountDeletionRequestRepository;

class DeleteAccountController extends Controller
{
    /**
     * repository instance
     *
     * @var App\Repository\AccountDeletionRequestRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\AccountDeletionRequestRepository $repository
     */
    public function __construct(AccountDeletionRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request) : Response
    {
        // validate request data
        $this->validateRequest($request);

        $escort = $this->getAuthUser();

        $deletion = $this->repository->store(
            [
                'reason' => $request->input('reason'),
            ],
            $escort
        );

        //notify admin
        $name = $this->getAuthUser()->name;
        $message = "<b>$name</b> deleted their account.";
        event(new WarnAdmin($message));

        $this->getAuthUser()->notify(new DeactivateEscort($escort->name));

        // redirects to next request
        return $this->redirectTo($deletion);
    }

    /**
     * validates incoming request
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'reason' => 'required'
            ]
        );
    }

    /**
     * redirects to next request
     *
     * @param  App\Models\AccountDeletionRequest $deletion
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    protected function redirectTo(AccountDeletionRequest $deletion) : Response
    {
        if (! $deletion->exists) {
            $this->notifyError(__('Unable to process your delete. Please try again sometime'));
            return back()->withInput(['notify' => 'account_deletion']);
        }

        $user = $deletion->user;

        // if delete request was success logout current user to the escort admin
        // then delete his/her account
        $user->delete();

        // logout
        $this->getAuthGuard()->logout();

        // notify
        $this->notifySuccess('Your account was succesfully deleted.');

        $this->removeEscortFilterCache();
        return redirect()->route('escort_admin.auth.login_form');
    }
}
