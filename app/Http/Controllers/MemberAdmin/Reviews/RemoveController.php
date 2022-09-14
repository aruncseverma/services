<?php

namespace App\Http\Controllers\MemberAdmin\Reviews;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserReviewRepository;

class RemoveController extends Controller
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * favorite repository instance
     *
     * @var App\Repository\UserReviewRepository
     */
    protected $reviewRepo;

    /**
     * create instance of this controller
     *
     * @param Request               $request
     * @param UserReviewRepository    $reviewRepo
     */
    public function __construct(
        Request $request,
        UserReviewRepository $reviewRepo
    ) {
        $this->request = $request;
        $this->reviewRepo = $reviewRepo;
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
        if (!$id = $this->request->input('id')) {
            $this->notifyError(__('Remove review requires identifier.'));
            return redirect()->back();
        }

        $review = $this->reviewRepo->find($id);
        if (!$review || $review->user_id != $user->getKey()) {
            $this->notifyError(__('Review not found.'));
            return redirect()->back();
        }

        // save data
        $res = $this->reviewRepo->delete($review->getKey());

        // notify next request
        if ($res) {
            $this->notifySuccess(__('Removed Successfully.'));
        } else {
            $this->notifyWarning(__('Unable to remove current request. Please try again sometime'));
        }

        return redirect()->back();
    }
}
