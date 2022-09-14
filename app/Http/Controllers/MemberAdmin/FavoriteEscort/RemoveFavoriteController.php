<?php

namespace App\Http\Controllers\MemberAdmin\FavoriteEscort;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\EscortRepository;
use App\Models\Favorite;
use App\Repository\FavoriteRepository;

class RemoveFavoriteController extends Controller
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
    public function handle(): RedirectResponse
    {
        $user = $this->getAuthUser();

        // notify and redirect if does not have any identifier
        if (!$username = $this->request->input('id')) {
            $this->notifyError(__('Remove favorite requires identifier.'));
            return redirect()->back();
        }

        $escort = $this->escortRepo->findUserByUsername($username);
        if (!$escort) {
            $this->notifyError(__('Escort not found.'));
            return redirect()->back();
        }

        // validate if data is already exists
        $favorite = $this->favoriteRepo->getByConditions([
            'user_id' => $user->getKey(),
            'object_type' => self::OBJECT_TYPE,
            'object_id' => $escort->getKey(),
        ]);

        if (!$favorite) {
            $this->notifyWarning(__('Escort is not favorite yet.'));
            return redirect()->back();
        }

        // remove data
        $res = $this->favoriteRepo->delete($favorite->getKey());

        // notify next request
        if ($res) {
            $this->notifySuccess(__('Removed Successfully.'));
        } else {
            $this->notifyWarning(__('Unable to remove current request. Please try again sometime'));
        }

        return redirect()->back();
    }
}
