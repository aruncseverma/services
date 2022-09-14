<?php
/**
 * updates escort password controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\AccountSettings;

use Illuminate\Http\Request;
use App\Repository\EscortRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Events\EscortAdmin\AccountSettings\ChangedAccountPassword;

class UpdatePasswordController extends Controller
{
    /**
     * repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\EscortRepository $repository
     */
    public function __construct(EscortRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * handle incoming requests
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request) : Response
    {
        $escort = $this->getAuthUser();

        $this->validateRequest($request);

        // proceeeds to updates password
        if ($this->changePassword($request->input('new_password'))) {
            $this->notifySuccess(__('Password successfully updated.'));
        } else {
            $this->notifyError(__('Password cannot be updated. Please try again sometime'));
        }

        return back()->withInput(['notify' => 'change_password']);
    }

    /**
     * validates requests
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
                'current_password' => 'required|current_password:' . $this->getAuthGuardName(),
                'confirm_password' => 'required|same:current_password',
                'new_password'     => 'required|min:6',
                'confirm_new_password' => 'required|same:new_password',
            ]
        );
    }

    /**
     * updates current password with new password
     *
     * @param  string $new
     *
     * @return boolean
     */
    protected function changePassword(string $new) : bool
    {
        $user = $this->repository->save(['password' => $new], $this->getAuthUser());

        /**
         * trigger event
         *
         * @param App\Models\Escort
         */
        event(new ChangedAccountPassword($user));

        return $user->wasChanged('password');
    }
}
