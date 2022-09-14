<?php
/**
 * controller class for updating escort main location
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use App\Models\UserLocation;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserLocationRepository;

class UpdateMainLocationController extends Controller
{
    /**
    * type
    *
    * @const
    */
    const LOCATION_TYPE = UserLocation::MAIN_LOCATION_TYPE;

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
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'update_main_location');
            $this->removeEscortFilterCache('country_id'); // [F] main location filter
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
            'main_location.continent' => ['required'],
            'main_location.country' => ['required'],
            'main_location.state' => ['required'],
            'main_location.city' => ['required'],
        ];

        $messages = [
            'main_location.continent.required' => 'The Continent field is required.',
            'main_location.country.required' => 'The Country field is required.',
            'main_location.state.required' => 'The State field is required.',
            'main_location.city.required' => 'The State field is required.',
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
        // save user location
        $this->saveUserLocation($user);

        return $user;
    }

    /**
     * save user description
     *
     * @param  App\Models\Escort $user
     *
     * @return void
     */
    protected function saveUserLocation(Escort $user) : void
    {

        $repository = app(UserLocationRepository::class);
        $location = $this->request->input('main_location');

        // save it
        $repository->store(
            [
                'continent_id' => $location['continent'],
                'country_id' => $location['country'],
                'state_id' => $location['state'],
                'city_id' => $location['city'],
                'type' => self::LOCATION_TYPE
            ],
            $user,
            $user->mainLocation
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
