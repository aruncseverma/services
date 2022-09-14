<?php
/**
 * abstract base controller for permissions namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Permissions;

use Illuminate\Http\Request;
use App\Repository\RoleRepository;
use App\Support\Concerns\InteractsWithAdminPermissions;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    use InteractsWithAdminPermissions;

    /**
     * request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * repository instance
     *
     * @var App\Repository\RoleRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\RoleRepository $repository
     */
    public function __construct(Request $request, RoleRepository $repository)
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
