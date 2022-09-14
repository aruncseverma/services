<?php

namespace App\Http\Controllers\MemberAdmin\FavoriteAgency;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserFollowerRepository;
use App\Repository\UserRepository;

class UnfollowController extends Controller
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
     * @var UserFollowerRepository
     */
    protected $followerRepo;

    /**
     * User Repository
     *
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * Undocumented function
     *
     * @param Request               $request
     * @param UserFollowerRepository    $followerRepo
     * @param UserRepository    $userRepo
     */
    public function __construct(Request $request, UserFollowerRepository $followerRepo, UserRepository $userRepo)
    {
        $this->request = $request;
        $this->followerRepo = $followerRepo;
        $this->userRepo = $userRepo;

        parent::__construct();
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(): RedirectResponse
    {
        $user = $this->getAuthUser();

        // notify and redirect if does not have any identifier
        if (!$followerId = $this->request->input('id')) {
            $this->notifyError(__('Unfollow requires identifier.'));
            return redirect()->back();
        }

        // validate if data is already exists
        $follower = $this->followerRepo->find($followerId);

        if (!$follower || $follower->follower_user_id != $user->getKey()) {
            $this->notifyWarning(__('Agency is not follow yet.'));
            return redirect()->back();
        }

        // remove data
        $res = $this->followerRepo->delete($follower->getKey());

        // notify next request
        if ($res) {
            $this->notifySuccess(__('Unfollowed.'));
        } else {
            $this->notifyWarning(__('Unable to unfollow current request. Please try again sometime'));
        }

        return redirect()->back();
    }
}
