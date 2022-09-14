<?php

namespace App\Http\Controllers\AgencyAdmin\Reviews;

use App\Http\Controllers\EscortAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\UserReviewReplyRepository;

class SeenReviewReplyController extends Controller
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * escort review reply repository instance
     *
     * @var App\Repository\UserReviewReplyRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\UserReviewReplyRepository $repository
     */
    public function __construct(Request $request, UserReviewReplyRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\Response
     */
    public function handle()
    {
        $user = $this->getAuthUser();
        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => __('Unauthorized')
            ]);
        }

        $ids = $this->request->input('ids');
        if (empty($ids)) {
            return response()->json([
                'status' => 0,
                'message' => __('Ids must be filled')
            ]);
        }

        $res = $this->repository->markReplyAsSeen($ids);
        if (!$res) {
            return response()->json([
                'status' => 0,
                'message' => __('Failed')
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => __('Success')
        ]);
    }
}