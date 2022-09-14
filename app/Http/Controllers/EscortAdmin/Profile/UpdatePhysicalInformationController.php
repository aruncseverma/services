<?php

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserDataRepository;

class UpdatePhysicalInformationController extends Controller
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
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'update_physical_information');
            $this->removeEscortFilterCache([
                'height', // basic filter > height, adv filter > physical > height
                'hair_color_id', // adv filter > physical > hair color
                'eye_color_id', // adv filter > physical > eye color
            ]);
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
            'hair_color_id' => ['required'],
            'cup_size_id' => ['required'],
            'eye_color_id' => ['required'],
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
        $userDataFields = ['hair_color_id', 'cup_size_id', 'eye_color_id', 'hair_length_2_liner_id', 'height_id', 'weight_id', 'blood_type_id', 'bust_id'];
        $repository = app(UserDataRepository::class);

        $fields = [];
        foreach ($userDataFields as $field) {
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
