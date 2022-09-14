<?php

namespace App\Http\Controllers\EscortAdmin\Followers;

use Illuminate\Http\Request;
use App\Repository\UserFollowerRepository;
use App\Http\Controllers\EscortAdmin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * escort reviews repository instance
     *
     * @var App\Repository\UserFollowerRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\UserFollowerRepository $repository
     */
    public function __construct(Request $request, UserFollowerRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }
}
