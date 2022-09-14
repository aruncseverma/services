<?php
/**
 * controller class for banning follower
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Followers;

use App\Models\Escort;
use Illuminate\Http\RedirectResponse;

class BanController extends Controller
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

        // notify and redirect if does not have any identifier
        if (! $this->request->input('id')) {
            $this->notifyError(__('Ban requires identifier.'));
            return redirect()->back();
        }

        // update data
        $user = $this->updateData($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully banned.'));
        } else {
            $this->notifyWarning(__('Unable to ban current request. Please try again sometime'));
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

        // gets previously set
        $data = $this->repository->findFollowerById($id, $user);

        // save it
        $this->repository->store(
            [
                'is_banned' => 1,
            ],
            $data->follower,
            $user,
            $data
        );

        return $user;
    }
}
