<?php
/**
 * controller class for rating follower
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Followers;

use App\Models\UserFollower;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class RateFollowerController extends Controller
{
    /**
    * minimum rate
    *
    * @const
    */
    const MIN_RATE = 1;

    /**
    * maximum rate
    *
    * @const
    */
    const MAX_RATE = 5;

    /**
     * handle incoming request
     *
     * @param  App\Models\UserFollower $follower
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(UserFollower $follower, Request $request) : RedirectResponse
    {
        // validates request data
        $this->validateRequest($request);

        $user = $this->getAuthUser();

        // validate ownership
        if ($follower->followed->getKey() != $user->getKey()) {
            $this->notifyWarning(__('It seems selected follower does not belong to you. Please your follower'));
            return $this->redirectTo();
        }

        // process request
        $this->saveRating($request->get('rate'), $follower);

        $this->notifySuccess(__('Follower rating saved successfully'));

        return $this->redirectTo();
    }

    /**
     * validate request data
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
                'rate' => 'min:' . static::MIN_RATE . '|max:' . static::MAX_RATE
            ]
        );
    }

    /**
     * save follower user rating
     *
     * @param  integer                 $rate
     * @param  App\Models\UserFollower $follower
     *
     * @return void
     */
    protected function saveRating(int $rate, UserFollower $follower) : void
    {
        $this->followers->save(
            [
                'follower_user_rating' => $rate,
            ],
            $follower
        );
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        return back()->withInput(['notify' => 'agency_followers']);
    }
}
