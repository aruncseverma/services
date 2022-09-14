<?php
/**
 * controller class for creating additional location of escort
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use App\Models\UserLocation;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserLocationRepository;

class AddAdditionalLocationController extends Controller
{
    /**
    * type
    *
    * @const
    */
    const LOCATION_TYPE = UserLocation::ADDITIONAL_LOCATION_TYPE;

    /**
    * maximum additional location
    *
    * @const
    */
    const MAX_ADDITIONAL_LOCATION = UserLocation::MAXIMUM_ADDITIONAL_LOCATION;

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

        // validate number of locations
        $total = $user->additionalLocation()->count();
        if ($total >= self::MAX_ADDITIONAL_LOCATION) {
            $this->notifyWarning(__('The additional location must be less than or equal to ') . self::MAX_ADDITIONAL_LOCATION);
            return $this->redirectTo($user);
        }

        // save user
        $user = $this->saveUser($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully saved.'));
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'add_additional_location');
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
            'additional_location.continent' => ['required'],
            'additional_location.country'  => ['required'],
            'additional_location.state' => ['required'],
            'additional_location.city' => ['required'],
        ];

        $messages = [
            'additional_location.continent.required' => 'The Continent field is required.',
            'additional_location.country.required' => 'The Country field is required.',
            'additional_location.state.required' => 'The State field is required.',
            'additional_location.city.required' => 'The State field is required.',
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
        $location = $this->request->input('additional_location');

        // save it
        $repository->store(
            [
                'continent_id' => $location['continent'],
                'country_id' => $location['country'],
                'state_id' => $location['state'],
                'city_id' => $location['city'],
                'type' => self::LOCATION_TYPE
            ],
            $user
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
