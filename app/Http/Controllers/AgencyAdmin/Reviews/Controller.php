<?php
/**
 * controller class for agency reviews
 *
 * @abstract
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Reviews;

use App\Repository\UserReviewRepository;
use App\Http\Controllers\AgencyAdmin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * create instance
     *
     * @param App\Repository\UserReviewRepository $reviews
     */
    public function __construct(UserReviewRepository $reviews)
    {
        parent::__construct();
        $this->reviews = $reviews;
    }
}
