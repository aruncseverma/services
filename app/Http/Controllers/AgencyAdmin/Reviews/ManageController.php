<?php
/**
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Reviews;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * render manage view template
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(Request $request) : View
    {
        $this->setTitle(__('Reviews'));

        //  get currently logged in user (agency)
        $agency = $this->getAuthUser();

        $search = array_merge(
            [
                'limit' => $limit = $this->getPageSize(),
            ],
            $request->query(),
            [
                'object_id' => $agency->getKey(),
                'page_param' => 'agency_page',
            ]
        );

        // look for all the reviews for this agency
        $agencyReviews = $this->reviews->search($limit, $search);

        // override object_id into ids
        $search['object_id'] = $agency->escorts->transform(function ($escort) use ($request) {
            if ($usernames = $request->get('escort_id')) {
                $usernames = explode(',', (string) $usernames);
                if (in_array($escort->username, $usernames)) {
                    return $escort->getKey();
                }
            } else {
                return $escort->getKey();
            }
        })->toArray();
        $search['page_param'] = 'escorts_page';

        $escortsReviews = $this->reviews->search($limit, $search);

        // review view
        return view('AgencyAdmin::reviews.manage', [
            'agencyReviews' => $agencyReviews,
            'escortsReviews' => $escortsReviews,
            'auth' => $agency,
        ]);
    }
}
