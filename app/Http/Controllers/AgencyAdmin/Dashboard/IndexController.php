<?php
/**
 * dashboard index controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Dashboard;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Repository\UserReviewRepository;
use App\Repository\UserViewRepository;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * user reviews repository instance
     *
     * @var App\Repository\UserReviewRepository
     */
    protected $reviews;

    /**
     * create instance
     *
     * @param App\Repository\UserReviewRepository $reviews
     */
    public function __construct(UserReviewRepository $reviews)
    {
        $this->reviews = $reviews;

        parent::__construct();
    }

    /**
     * handle dashboard request
     *
     * @param Request $request
     * @return Illuminate\Contracts\View\View
     */
    public function handle(Request $request) : View
    {
        $this->setTitle(__('Dashboard'));

        $user = $this->getAuthUser();

        $viewRepo = app(UserViewRepository::class);

        return view('AgencyAdmin::dashboard.index', [
            'followers' => $this->getFollowers($user),
            'reviews' => $this->getReviews($user),
            'latestReviews' => $this->getLatestReviews($user),
            'escortsLatestReviews' => $this->getEscortLatestReviews($user),
            'visitorGraphSelections' => $viewRepo->getVisitorGraphSelection(),
            'profileViews' => $user->totalViews(),
            'rating' => $user->getRating(),
            'ranking' => $user->getRanking(),
            'visitorGraphData' => $viewRepo->getVisitorGraphData($user, 'device_type', $request->period),
        ]);
    }

    /**
     * get followers count
     *
     * @param  App\Models\User $user
     *
     * @return integer
     */
    protected function getFollowers(User $user) : int
    {
        return $user->followers->count();
    }

    /**
     * get reviews count
     *
     * @param  App\Models\User $user
     *
     * @return integer
     */
    protected function getReviews(User $user) : int
    {
        return $user->reviews->count();
    }

    /**
     * get all latest reviews upto date
     *
     * @param  App\Models\User $user
     *
     * @return Illuminate\Support\Collection
     */
    protected function getLatestReviews(User $user) : Collection
    {
        return $this->reviews->getLatestReviews($user, 5);
    }

    /**
     * get escort latest reviews
     *
     * @param  App\Models\User $user
     *
     * @return mixed
     */
    protected function getEscortLatestReviews(User $user)
    {
        $search = [];
        $search['object_id'] = $user->escorts->transform(function ($escort) {
            return $escort->getKey();
        })->toArray();
        $search['is_latest'] = true;

        return $this->reviews->search(5, $search);
    }
}
