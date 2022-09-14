<?php
/**
 * controller class for updating "Locality" section of escort
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserGeoLocationRepository;

class UpdateGeoLocationController extends Controller
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
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'update_locality');
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
            'geo_location_lat' => ['required'],
            'geo_location_long' => ['required'],
        ];

        $messages = [
            'geo_location_lat.required' => 'The Latitude field is required.',
            'geo_location_long.required' => 'The Longitude field is required.',
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules,
            $messages
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
        // save user geo location
        $this->saveUserGeoLocation($user);

        return $user;
    }

    /**
     * save user geo location
     *
     * @param  App\Models\Escort $user
     *
     * @return void
     */
    protected function saveUserGeoLocation(Escort $user) : void
    {

        $repository = app(UserGeoLocationRepository::class);

        // save it
        $repository->store(
            [
                'lat' => $this->request->input('geo_location_lat'),
                'long' => $this->request->input('geo_location_long'),
            ],
            $user,
            $user->geoLocation
        );
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
