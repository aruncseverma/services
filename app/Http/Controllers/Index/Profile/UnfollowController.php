<?php

namespace App\Http\Controllers\Index\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\EscortRepository;
use App\Repository\UserFollowerRepository;

class UnfollowController extends Controller
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * escort repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $escortRepo;

    /**
     * follower repository instance
     *
     * @var App\Repository\UserFollowerRepository
     */
    protected $followerRepo;

    /**
     * create instance of this controller
     *
     * @param Request               $request
     * @param EscortRepository      $escortRepo
     * @param UserFollowerRepository    $followerRepo
     */
    public function __construct(
        Request $request,
        EscortRepository $escortRepo,
        UserFollowerRepository $followerRepo
    ) {
        $this->request = $request;
        $this->escortRepo = $escortRepo;
        $this->followerRepo = $followerRepo;
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(): RedirectResponse
    {
        $user = $this->getAuthUser();
        if (!$user) {
            $this->notifyError(__('Please login to proceed.'));
            return redirect()->back();
        }

        // notify and redirect if does not have any identifier
        if (!$username = $this->request->input('id')) {
            $this->notifyError(__('Unfollow requires identifier.'));
            return redirect()->back();
        }

        $escort = $this->escortRepo->findUserByUsername($username);
        if (!$escort) {
            $this->notifyError(__('Escort not found.'));
            return redirect()->back();
        }

        // validate if data is already exists
        $follower = $this->followerRepo->findFollowerByFollowerId($user->getKey(), $escort);
        if (!$follower) {
            $this->notifyError(__('Escort is not follow yet.'));
            return redirect()->back();
        }

        // delete data
        $res = $this->followerRepo->delete($follower->getKey());

        // notify next request
        if ($res) {
            $this->notifySuccess(__('Unfollowed.'));
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }

        return redirect()->back();
    }
}
