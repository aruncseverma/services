<?php
/**
 * controller class for creating reply for review
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Reviews;

use App\Models\Escort;
use App\Models\UserReview;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserReviewRepository;
use App\Repository\UserReviewReplyRepository;

class ReplyController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $user = $this->getAuthUser();
        if (! $user) {
            $this->notifyError(__('User not found.'));
            return redirect()->back();
        }

        // notify and redirect if does not have any identifier
        if (! $this->request->input('id')) {
            $this->notifyError(__('Reply requires identifier.'));
            return redirect()->back();
        }

        $repository = app(UserReviewRepository::class);
        $review = $repository->findReviewById($this->request->input('id'), $user);
        if (! $review) {
            $this->notifyError(__('Review not found.'));
            return redirect()->back();
        }

        // validate request if passed then proceeds to saving reply
        $this->validateRequest($user);

        // save data
        $user = $this->saveData($user, $review);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully saved.'));
            $this->addUserActivity(self::ACTIVITY_TYPE, $review->getKey(), 'reply');
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }

        return redirect()->back();
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\Escort|null $user
     *
     * @return void
     */
    protected function validateRequest(Escort $user = null) : void
    {
        $rules = [
            'content' => ['required'],
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
     * @param  App\Models\Escort|null $user
     * @param  App\Models\UserReview|null $review
     *
     * @return App\Models\Escort
     */
    protected function saveData(Escort $user = null, UserReview $review = null) : Escort
    {
        $repository = app(UserReviewReplyRepository::class);

        // save it
        $repository->store(
            [
                'content' => $this->request->input('content'),
            ],
            $user,
            $review
        );

        return $user;
    }
}
