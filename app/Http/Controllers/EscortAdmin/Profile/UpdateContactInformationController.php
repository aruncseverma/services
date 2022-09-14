<?php

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserDataRepository;

class UpdateContactInformationController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {

        $user = $this->getAuthUser();
        if (! $user) {
            $this->notifyError(__('User not found.'));
            return redirect()->back();
        }

        // validate request if passed then proceeds to saving user info
        $this->validateRequest($user);

        // save user
        $user = $this->saveUser($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully saved.'));
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'update_contact_information');
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }
        return $this->redirectTo($user);
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\Escort|null $user
     *
     * @return void
     */
    protected function validateRequest(Escort $user = null) : void
    {
        $rules = [
            'contact_number' => ['required'],
            'skype_id' => ['required'],
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules
        );
    }

    /**
     * save user data
     *
     * @param  App\Models\Escort|null $user
     *
     * @return App\Models\Escort
     */
    protected function saveUser(Escort $user = null) : Escort
    {
        $attributes = [
            'phone'      => $this->request->input('contact_number'),
        ];

        // save to repository
        $user = $this->repository->save($attributes, $user);

        // save user data
        $this->saveUserData($user);

        return $user;
    }

    /**
     * save user data
     *
     * @param  App\Models\Escort $user
     *
     * @return void
     */
    protected function saveUserData(Escort $user) : void
    {
        $userDataFields = ['skype_id', 'contact_platform_ids'];
        $repository = app(UserDataRepository::class);

        $fields = [];
        foreach($userDataFields as $field) {
            $fields[$field] = $this->request->input($field, '');
        }
        $repository->saveUserData($user, $fields);
    }

    /**
     * redirect to next route
     *
     * @param  App\Models\Escort $user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Escort $user) : RedirectResponse
    {
        return redirect()->route('escort_admin.profile');
    }
}
