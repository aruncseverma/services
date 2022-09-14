<?php
/**
 * base controller for profile namespace
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 * @abstract
 */

namespace App\Http\Controllers\EscortAdmin\Profile;

use Illuminate\Http\Request;
use App\Models\Escort;
use App\Repository\EscortRepository;
use App\Http\Controllers\EscortAdmin\Controller as BaseController;
use App\Models\UserActivity;
use App\Support\Concerns\EscortFilterCache;

abstract class Controller extends BaseController
{
    use EscortFilterCache;

   /**
    * default type
    *
    * @const
    */
    const DEFAULT_TYPE = Escort::USER_TYPE;

    /**
     * default user activity type
     *
     * @const
     */
    const ACTIVITY_TYPE = UserActivity::ESCORT_TYPE;

    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * users repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\EscortRepository $repository
     */
    public function __construct(Request $request, EscortRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }
}
