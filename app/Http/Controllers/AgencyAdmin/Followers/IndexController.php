<?php
/**
 * followers index controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Followers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * handle reviews request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle(Request $request) : View
    {
        // set title
        $this->setTitle(__('Followers'));

        $user = $this->getAuthUser();
        $search = $request->query();

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
            ],
            $search,
            [
                'followed_user_id' => $user->getKey(),
                'is_banned' => false,
                'page_param' => 'agency_followers_page'
            ]
        );

        // get escort reviews from repository
        $agencyFollowers = $this->followers->search($limit, $search);

        // change parameters
        $search = array_merge(
            $search,
            [
                'page_param' => 'escorts_followers_page',
                'followed_user_id' => $user->escorts->transform(function ($escort) {
                    return $escort->getKey();
                })->toArray(),
                'is_banned' => false,
            ]
        );
        $escortsFollowers = $this->followers->search($limit, $search);

        return view('AgencyAdmin::followers.index', [
            'agencyFollowers' => $agencyFollowers,
            'escortsFollowers' => $escortsFollowers,
        ]);
    }
}
