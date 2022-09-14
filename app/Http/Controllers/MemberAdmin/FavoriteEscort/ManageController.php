<?php
namespace App\Http\Controllers\MemberAdmin\FavoriteEscort;

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
        $this->setTitle(__('MY FAVORITE ESCORTS'));

        $search = array_merge(
            [
                'limit' => $limit = $this->getPageSize(),
            ],
            $request->query(),
            [
                'user_id' => $this->getAuthUser()->getKey(),
                'object_type' => Favorite::ESCORT_TYPE,
                'with_data' => 'escort',
            ]
        );

        $favorites = $this->favorite->search($limit, $search);

        foreach ($favorites as $key => $value) {
            $value->escort->setAttribute('profilePhotoUrl', $value->escort->getProfileImage());
            $value->escort->setAttribute('origin', $value->escort->getOriginAttribute());
            $value->escort->setAttribute('totalPhotos', $value->escort->getTotalPhotos());
            $value->escort->setAttribute('totalVideos', $value->escort->getTotalVideos());
        }

        return view('MemberAdmin::favorite_escorts.manage', [
            'favorites' => $favorites,
        ]);
    }
}
