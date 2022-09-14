<?php

namespace App\Http\Controllers\MemberAdmin\FavoriteAgency;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserFollowerRepository;
use App\Repository\UserRepository;

class FollowController extends Controller
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
    public function __construct(Request$request, UserFollowerRepository$followerRepo, UserRepository $userRepo)
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
        if (!$username = $this->request->input('id')) {
            $this->notifyError(__('Follow requires identifier.'));
            return redirect()->back();
        }

        $agency = $this->userRepo->findUserByUsername($username);
        if (!$agency) {
            $this->notifyError(__('Agency not found.'));
            return redirect()->back();
        }

        // validate if data is already exists
        $followers = $this->followerRepo->getFollowedUserIds($user, [
            'followed_user_id' => $agency->getKey(),
        ]);

        if ($followers) {
            $this->notifyWarning(__('Agency already followed.'));
            return redirect()->back();
        }

        // save data
        $follower = $this->followerRepo->store([], $user, $agency);

        // notify next request
        if ($follower) {
            $this->notifySuccess(__('Followed.'));
        } else {
            $this->notifyWarning(__('Unable to follow current request. Please try again sometime'));
        }

        return redirect()->back();
    }
}
