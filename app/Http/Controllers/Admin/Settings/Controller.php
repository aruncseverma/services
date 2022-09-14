<?php
/**
 * base controller class for settings namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Repository\SettingRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * request instance
     *
     * @var Illuminate\Http\Reques
     */
    protected $request;

    /**
     * repository instance
     *
     * @var App\Repository\SettingRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param Illuminate\Http\Request          $request
     * @param App\Repository\SettingRepository $repository
     */
    public function __construct(Request $request, SettingRepository $repository)
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
