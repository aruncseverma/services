<?php

namespace App\Http\Controllers\MemberAdmin\Reviews;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Repository\UserReviewRepository;

class ManageController extends Controller
{
    /**
     * Request Variable
     *
     * @var Illuminate\Http\Request
     */
    protected $request;


    /**
     * UserReview Repository
     *
     * @var UserReviewRepository
     */
    protected $review;

    /**
     * Undocumented function
     *
     * @param Request               $request
     * @param MemberRepository         $member
     */
    public function __construct(Request $request, UserReviewRepository $review)
    {
        $this->request = $request;
        $this->review = $review;

        parent::__construct();
    }

    /**
     * renders the emails listing view
     *
     * @param  Illuminate\Http\Request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $this->setTitle(__('Reviews'));

        $search = array_merge(
            [
                'limit' => $limit = $this->getPageSize(),
            ],
            $request->query(),
            [
                'user_id' => $this->getAuthUser()->getKey(),
            ]
        );

        $reviews = $this->review->search($limit, $search);

        foreach ($reviews as $key => $value) {
            $value->object->setAttribute('profilePhotoUrl', $value->object->getProfileImage());
        }

        return view('MemberAdmin::reviews.manage', [
            'reviews' => $reviews,
        ]);
    }
}
