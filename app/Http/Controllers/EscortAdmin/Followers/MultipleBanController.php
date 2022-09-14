<?php
/**
 * controller class for multiple banning followers
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Followers;

use App\Models\Escort;
use Illuminate\Http\RedirectResponse;

class MultipleBanController extends Controller
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
        if (! $this->request->input('ids')) {
            $this->notifyError(__('Ban requires identifier.'));
            return redirect()->back();
        }

        // update data
        $banned = $this->updateData($user);

        // notify next request
        if ($banned) {
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
     * @return integer
     */
    protected function updateData(Escort $user = null) : int
    {
        $ids = $this->request->input('ids');

        if (! $ids) {
            return 0;
        }

        $ids = is_array($ids) ? $ids : [$ids];
        $attributes = [
            'is_banned' => 1
        ];

        return $this->repository->updateFollowerByIds($attributes, $ids, $user);
    }
}
