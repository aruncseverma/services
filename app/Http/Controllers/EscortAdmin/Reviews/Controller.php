<?php
/**
 * base controller for reviews namespace
 *
 */

namespace App\Http\Controllers\EscortAdmin\Reviews;

use Illuminate\Http\Request;
use App\Repository\UserReviewRepository;
use App\Http\Controllers\EscortAdmin\Controller as BaseController;
use App\Models\UserActivity;

abstract class Controller extends BaseController
{
    /**
     * default user activity type
     *
     * @const
     */
    const ACTIVITY_TYPE = UserActivity::REVIEW_TYPE;

    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * escort reviews repository instance
     *
     * @var App\Repository\UserReviewRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\UserReviewRepository $repository
     */
    public function __construct(Request $request, UserReviewRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }
}
