<?php
/**
 * base class for all administrator controllers
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Administrators;

use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Repository\AdministratorRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * default type
     *
     * @const
     */
    const DEFAULT_TYPE = Administrator::USER_TYPE;

    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * users repository instance
     *
     * @var App\Repository\AdministratorRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\AdministratorRepository $repository
     */
    public function __construct(Request $request, AdministratorRepository $repository)
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
