<?php
/**
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Reviews;

use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserReviewRepository;
use App\Repository\UserReviewReplyRepository;

class ReplyController extends Controller
{
    /**
     * create instance
     *
     * @param App\Repository\UserReviewRepository $reviews
     * @param App\Repository\UserReviewReplyRepository $replies
     */
    public function __construct(UserReviewRepository $reviews, UserReviewReplyRepository $replies)
    {
        parent::__construct($reviews);
        $this->replies = $replies;
    }

    /**
     * handle incoming request data
     *
     * @param  App\Models\UserReview   $review
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(UserReview $review, Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        // save reply
        $this->replies->store(
            [
                'content' => $request->input('content'),
            ],
            $this->getAuthUser(),
            $review
        );

        // notify
        $this->notifySuccess(__('Reply successfully saved'));

        return back()->withInput(['notify' => $request->input('notify')]);
    }

    /**
     * validate incoming request data
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'content' => 'required'
            ]
        );
    }
}
