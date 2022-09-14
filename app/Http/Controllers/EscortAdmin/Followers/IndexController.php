<?php
/**
 * followers index controller
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Followers;

use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * handle reviews request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle() : View
    {
        $user = $this->getAuthUser();
        $search = $this->request->query();
        $search['followed_user_id'] = $user->getKey();
        $search['is_banned'] = 0;

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
            ],
            $search
        );

        // get escort reviews from repository
        $followers = $this->repository->search($limit, $search);

        // set title
        $this->setTitle(__('Followers'));

        return view('EscortAdmin::followers.index', [
            'followers' => $followers,
        ]);
    }
}
