<?php
namespace App\Http\Controllers\MemberAdmin\FavoriteAgency;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Repository\FavoriteRepository;
use App\Models\Favorite;

class ManageController extends Controller
{
    /**
     * Request Variable
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * Favorite Repository
     *
     * @var FavoriteRepository
     */
    protected $favorite;

    /**
     * Undocumented function
     *
     * @param Request               $request
     * @param FavoriteRepository    $favorite
     */
    public function __construct(Request $request, FavoriteRepository $favorite)
    {
        $this->request = $request;
        $this->favorite = $favorite;

        parent::__construct();
    }

    /**
     * renders the emails listing view
     *
     * @param  Illuminate\Http\Request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $this->setTitle(__('MY FAVORITE AGENCIES'));

        $user = $this->getAuthUser();
        $search = array_merge(
            [
                'limit' => $limit = $this->getPageSize(),
            ],
            $request->query(),
            [
                'user_id' => $this->getAuthUser()->getKey(),
                'object_type' => Favorite::AGENCY_TYPE,
                'with_data' => ['agency', 'agency.description'],
            ]
        );

        $favorites = $this->favorite->search($limit, $search);

        $followedUsersKey = [];
        foreach ($favorites as $key => $value) {
            $value->agency->setAttribute('profilePhotoUrl', $value->agency->getProfileImage());
            $value->agency->setAttribute('totalEscorts', $value->agency->getTotalEscorts());
            $value->agency->setAttribute('totalReviews', $value->agency->getTotalReviews());
            $value->agency->setAttribute('rating', $value->agency->getRating());
            
            $followedUsersKey[$value->agency->getKey()] = $key;
            $value->agency->setAttribute('follower_id', 0);
        }

        // add follower flag
        $followerRepo = app(\App\Repository\UserFollowerRepository::class);
        $ids = $followerRepo->getFollowedUserIds($user, [
            'followed_user_id' => array_keys($followedUsersKey)
        ]);
        if (!empty($ids)) {
            foreach($ids as $followerId => $userId) {
                $favorites[$followedUsersKey[$userId]]->agency->setAttribute('follower_id', $followerId);
            }
        }

        return view('MemberAdmin::favorite_agencies.manage', [
            'favorites' => $favorites,
        ]);
    }
}
