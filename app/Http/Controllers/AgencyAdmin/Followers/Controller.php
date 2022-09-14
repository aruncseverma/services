<?php
/**
 * base controller for followers namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 * @abstract
 */

namespace App\Http\Controllers\AgencyAdmin\Followers;

use App\Repository\UserFollowerRepository;
use App\Http\Controllers\AgencyAdmin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * followers repository instance
     *
     * @var App\Repository\UserFollowerRepository
     */
    protected $followers;

    /**
     * create instance of this controller
     *
     * @param App\Repository\UserFollowerRepository $repository
     */
    public function __construct(UserFollowerRepository $followers)
    {
        $this->followers = $followers;

        parent::__construct();
    }
}
