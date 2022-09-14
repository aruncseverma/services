<?php

namespace App\Http\Controllers\Index\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Escort;
use App\Repository\EscortRepository;
use App\Models\User;
use App\Repository\UserFollowerRepository;

class FollowController extends Controller
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
            $this->notifyError(__('Follow requires identifier.'));
            return redirect()->back();
        }

        $escort = $this->escortRepo->findUserByUsername($username);
        if (!$escort) {
            $this->notifyError(__('Escort not found.'));
            return redirect()->back();
        }

        // validate if data is already exists
        if ($this->followerRepo->findFollowerByFollowerId($user->getKey(), $escort)) {
            $this->notifyWarning(__('Escort is already followed.'));
            return redirect()->back();
        }

        // save data
        $user = $this->saveData($user, $escort);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Followed.'));
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }

        return redirect()->back();
    }

    /**
     * save data
     *
     * @param  User|null $user
     * @param  Escort|null $escort
     * @return User
     */
    protected function saveData(User $user = null, Escort $escort = null): User
    {
        // save it
        $this->followerRepo->store(
            [
                'followed_user_rating' => $this->request->rating ?? 0,
            ],
            $user,
            $escort
        );

        return $user;
    }
}
