<?php

namespace App\Http\Controllers\Index\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Escort;
use App\Repository\EscortRepository;
use App\Models\User;
use App\Notifications\Index\Profile\NewReview;
use App\Repository\UserReviewRepository;
use App\Support\Concerns\EscortFilterCache;

class AddReviewController extends Controller
{
    use EscortFilterCache;

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
     * review repository instance
     *
     * @var App\Repository\UserReviewRepository
     */
    protected $reviewRepo;

    /**
     * create instance of this controller
     *
     * @param Request                   $request
     * @param EscortRepository          $escortRepo
     * @param UserReviewRepository    $reviewRepo
     */
    public function __construct(
        Request $request,
        EscortRepository $escortRepo,
        UserReviewRepository $reviewRepo
    ) {
        $this->request = $request;
        $this->escortRepo = $escortRepo;
        $this->reviewRepo = $reviewRepo;
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
            $this->notifyError(__('Write a review requires identifier.'));
            return redirect()->back();
        }

        $escort = $this->escortRepo->findUserByUsername($username);
        if (! $escort) {
            $this->notifyError(__('Escort not found.'));
            return redirect()->back();
        }

        // validate request if passed then proceeds to saving reply
        $this->validateRequest($user);

        // save data
        $user = $this->saveData($user, $escort);

        // notify escort
        $escort->notify(new NewReview($user->name, $this->request->input('rating'), $this->request->input('content')));

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Review successfully saved.'));
            $this->removeEscortFilterCache('reviews');
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }

        return redirect()->back();
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\User|null $user
     *
     * @return void
     */
    protected function validateRequest(User $user = null) : void
    {
        $rules = [
            'content' => ['required'],
            'rating' => ['required'],
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules
        );
    }

    /**
     * save data
     *
     * @param  User|null $user
     * @param  Escort|null $escort
     *
     * @return User
     */
    protected function saveData(User $user = null, Escort $escort = null) : User
    {
        $repository = app(UserReviewRepository::class);

        // save it
        $repository->store(
            [
                'content' => $this->request->input('content'),
                'rating' => $this->request->input('rating'),
                'object_id' => $escort->getKey(),
            ],
            $user
        );

        return $user;
    }
}
