<?php
/**
 * dashboard index controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Dashboard;

use App\Models\User;
use App\Models\UserView;
use App\Repository\EscortRepository;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Repository\UserReviewRepository;
use App\Repository\UserViewRepository;
use Illuminate\Http\Request;
use App\Support\Concerns\IsActionWithinPlan;
use PhpParser\Node\Expr\Cast\Double;

class IndexController extends Controller
{

    use IsActionWithinPlan;

    /**
     * handle dashboard request
     *
     * @param Request $request
     * @return Illuminate\Contracts\View\View
     */
    public function handle(Request $request) : View
    {
        $this->setTitle(__('Dashboard'));

        $repo = app(EscortRepository::class);

        $user = $this->getAuthUser();
        $escort = $repo->find($user->getKey());

        $viewRepo = app(UserViewRepository::class);
        $unreadNotifications = $escort->unreadNotifications;

        return view('EscortAdmin::dashboard.index', [
            'escort' => $escort,
            'followers' => $this->getFollowers($user),
            'reviews' => $this->getReviews($user),
            'latestReviews' => $this->getLatestReviews($user),
            'visitorGraphSelections' => $viewRepo->getVisitorGraphSelection(),
            'profileViews' => $user->totalViews(),
            'rating' => $user->getRating(),
            'ranking' => $user->getRanking(),
            'visitorGraphData' => $viewRepo->getVisitorGraphData($user, 'device_type', $request->period),
            'totalViews' => $this->getUserViews($user),
            'ratings' => $this->getTotalRatings($user),
            'visitorGraphSelections' => $this->getVisitorGraphSelection(),
            'unreadNotifications' => $unreadNotifications
        ]);
    }

    /**
     * get followers count
     *
     * @param  App\Models\User $user
     *
     * @return integer
     */
    protected function getFollowers(?User $user) : int
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
    protected function getReviews(?User $user) : int
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
    protected function getLatestReviews(?User $user) : Collection
    {
        $repository = app(UserReviewRepository::class);

        return $repository->getLatestReviews($user, 5);
    }

    /**
     * @author Jhay Bagas <bagas.jhay@email.com>
     * get total views upto date
     *
     * @param App\Models\User $user
     *
     * @return integer
     */
    protected function getUserViews(?User $user) : int
    {
        $repository = app(UserViewRepository::class);

        return $repository->getTotalViews($user);
    }

    /**
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     * get average escort rating upto date
     *
     * @param User $user
     *
     * @return double
     */
    protected function getTotalRatings(?User $user)
    {
        $repository = app(UserReviewRepository::class);

        return $repository->getReviewRatingAverage($user);
    }

    /**
     * get all visitor graph selection
     *
     * @return void
     */
    protected function getVisitorGraphSelection()
    {
        return [
            'today' => __('Today'),
            'yesterday' => __('Yesterday'),
            'last_week' => __('Last Week'),
            'last_14_days' => __('Last 14 Days'),
            'last_30_days' => __('Last 30 Days')
        ];
    }
}
