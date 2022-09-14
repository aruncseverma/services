<?php
/**
 * delete follower controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Followers;

use App\Models\Agency;
use App\Models\Escort;
use App\Models\UserFollower;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DeleteFollowerController extends Controller
{
    /**
     * handles incoming request
     *
     * @param  App\Models\UserFollower $follower
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(UserFollower $follower, Request $request) : RedirectResponse
    {
        $user = $this->getAuthUser();

        // validate ownership
        $followed = $follower->followed;
        if ($followed->type == Escort::USER_TYPE && ! $user->escorts->contains($followed->getKey())) {
            $this->notifyWarning(__('It seems selected follower does not belong to any of your escorts'));
            return $this->redirectTo($request);
        } elseif ($followed->type == Agency::USER_TYPE && $followed->getKey() != $user->getKey()) {
            $this->notifyWarning(__('It seems selected follower does not belong to you. Please your follower'));
            return $this->redirectTo($request);
        }

        // process delete
        $this->followers->delete($follower->getKey());
        $this->notifySuccess(__('Follower deleted successfully'));

        return $this->redirectTo($request);
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Request $request) : RedirectResponse
    {
        return back()->withInput(['notify' => $request->get('notify', 'agency_followers')]);
    }
}
