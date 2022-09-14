<?php
/**
 * base class for all Agency controllers
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Agency;

use App\Models\Agency;
use Illuminate\Http\Request;
use App\Repository\AgencyRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
   /**
    * default type
    *
    * @const
    */
    const DEFAULT_TYPE = Agency::USER_TYPE;

    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * users repository instance
     *
     * @var App\Repository\AgencyRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\AgencyRepository $repository
     */
    public function __construct(Request $request, AgencyRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        // call middlewares
        $this->attachMiddleware();

        parent::__construct();
    }

    /**
     * attach middleware(s) for this controller
     *
     * @return void
     */
    abstract protected function attachMiddleware() : void;
}
