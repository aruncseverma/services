<?php
/**
 * controller class for rating follower
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Followers;

use App\Models\Escort;
use Illuminate\Http\RedirectResponse;

class RateCustomerController extends Controller
{
    /**
    * minimum rate
    *
    * @const
    */
    const MIN_RATE = 0;

    /**
    * maximum rate
    *
    * @const
    */
    const MAX_RATE = 5;

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

        // notify and redirect if does not have any identifier
        if (! $this->request->input('id')) {
            $this->notifyError(__('Rate customer requires identifier.'));
            return redirect()->back();
        }

        // notify and redirect if does not have any rate or invalid rate
        $rate = $this->request->input('rate');
        if (! $rate) {
            $this->notifyError(__('Rate customer requires rate value.'));
            return redirect()->back();
        } else if ($rate < self::MIN_RATE || $rate > self::MAX_RATE) {
            $this->notifyError(__('Invalid rate value.'));
            return redirect()->back();
        }

        // update data
        $user = $this->updateData($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully saved.'));
        } else {
            $this->notifyWarning(__('Unable to rate current request. Please try again sometime'));
        }

        return redirect()->back();
    }

    /**
     * save data
     *
     * @param  App\Models\Escort|null $user
     *
     * @return App\Models\Escort
     */
    protected function updateData(Escort $user = null) : Escort
    {
        $id = $this->request->input('id');
        $rate = $this->request->input('rate');

        // gets previously set
        $data = $this->repository->findFollowerById($id, $user);

        // save it
        $this->repository->store(
            [
                'follower_user_rating' => $rate,
            ],
            $data->follower,
            $user,
            $data
        );

        return $user;
    }
}
