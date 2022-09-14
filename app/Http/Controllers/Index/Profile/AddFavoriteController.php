<?php

namespace App\Http\Controllers\Index\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Escort;
use App\Repository\EscortRepository;
use App\Models\User;
use App\Models\Favorite;
use App\Notifications\EscortAdmin\Follower\NewFollower;
use App\Repository\FavoriteRepository;

class AddFavoriteController extends Controller
{
    /**
    * type
    *
    * @const
    */
    const OBJECT_TYPE = Favorite::ESCORT_TYPE;

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
     * favorite repository instance
     *
     * @var App\Repository\FavoriteRepository
     */
    protected $favoriteRepo;

    /**
     * create instance of this controller
     *
     * @param Request               $request
     * @param EscortRepository      $escortRepo
     * @param FavoriteRepository    $favoriteRepo
     */
    public function __construct(
        Request $request, 
        EscortRepository $escortRepo,
        FavoriteRepository $favoriteRepo
    ) {
        $this->request = $request;
        $this->escortRepo = $escortRepo;
        $this->favoriteRepo = $favoriteRepo;
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $user = $this->getAuthUser();
        if (! $user) {
            $this->notifyError(__('Please login to proceed.'));
            return redirect()->back();
        }

        // notify and redirect if does not have any identifier
        if (! $username = $this->request->input('id')) {
            $this->notifyError(__('Add favorite requires identifier.'));
            return redirect()->back();
        }

        $escort = $this->escortRepo->findUserByUsername($username);
        if (! $escort) {
            $this->notifyError(__('Escort not found.'));
            return redirect()->back();
        }

        // validate if data is already exists
        if ($this->favoriteRepo->getByConditions([
            'user_id' => $user->getKey(),
            'object_type' => self::OBJECT_TYPE,
            'object_id' => $escort->getKey(),
        ])) {
            $this->notifyWarning(__('Escort is already favorited.'));
            return redirect()->back();
        }

        // save data
        $user = $this->saveData($user, $escort);

        // add action to notification
        $escort->notify(new NewFollower($user->name));

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Add favorite successfully saved.'));
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }

        return redirect()->back();
    }

    /**
     * save data
     *
     * @param  UserUser|null $user
     * @param  Escort|null $escort
     * @return User
     */
    protected function saveData(User $user = null, Escort $escort = null) : User
    {
        // save it
        $this->favoriteRepo->store(
            [
                'object_type' => self::OBJECT_TYPE,
                'object_id' => $escort->getKey(),
            ],
            $user
        );

        return $user;
    }
}
