<?php
/**
 * controller class for deleting escort location
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserLocationRepository;

class DeleteLocationController extends Controller
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

        // delete user location
        $user = $this->deleteLocation($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully saved.'));
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'delete_additional_location');
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }
        return $this->redirectTo($user);
    }

    /**
     * delete user location
     *
     * @param  App\Models\Escort|null $user
     *
     * @return App\Models\Escort
     */
    protected function deleteLocation(Escort $user = null) : Escort
    {
        $repository = app(UserLocationRepository::class);
        $locationId = $this->request->input('id');

        // gets previously set
        $data = $repository->findUserLocationById($locationId, $user);

        // if has model set delete that
        if ($data) {
            $repository->delete($data->getKey());
        }

        return $user;
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
