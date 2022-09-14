<?php

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserDataRepository;

class UpdateBasicInformationController extends Controller
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
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'update_basic_information');
            $this->removeEscortFilterCache([
                'search', // [F] searcbox - for escort name
                'gender', // [F] gender area filter, adv. filter > physical > gender
                'orientation', // [B] Orientation 2 Liner // [F] basic filter > Orientation
                'age', // [B] birthday // [F] age
                'origin', // [B] origin // [F] basic filter > origin
                'service_type', // [B] service type, // [F] basic filter > availability
                'ethnicity', // [B] Ethnizität , [F] main filter > ethnicity
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
            'name'            => ['nullable'],
            'origin_id'         => ['required'],
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
            'name'      => $this->request->input('name'),
            'gender' => $this->request->input('gender'),
            'birthdate' => $this->request->input('birthdate')
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
        $userDataFields = ['origin_id', 'orientation_2_liner', 'service_type', 'social', 'pornstar','ethnicity_id','ethnicity_id2'];
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
