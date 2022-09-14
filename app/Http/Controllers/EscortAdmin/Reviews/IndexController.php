<?php
/**
 * reviews index controller
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Reviews;

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
        $search['object_id'] = $user->getKey();

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
            ],
            $search
        );

        // get escort reviews from repository
        $reviews = $this->repository->search($limit, $search);

        // set title
        $this->setTitle(__('Reviews'));

        return view('EscortAdmin::reviews.index', [
            'reviews' => $reviews,
            'auth' => $user,
        ]);
    }
}
