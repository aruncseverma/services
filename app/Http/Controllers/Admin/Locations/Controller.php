<?php
/**
 * base controller for locations namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Locations;

use Illuminate\Http\Request;
use App\Repository\CityRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * repository instance
     *
     * @var App\Repository\CityRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\CityRepository $repository
     */
    public function __construct(Request $request, CityRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }
}
