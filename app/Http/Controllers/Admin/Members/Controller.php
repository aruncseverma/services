<?php

namespace App\Http\Controllers\Admin\Members;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Repository\MemberRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * default type
     *
     * @const
     */
    const DEFAULT_TYPE = Member::USER_TYPE;

    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * users repository instance
     *
     * @var App\Repository\MemberRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\MemberRepository $repository
     */
    public function __construct(Request $request, MemberRepository $repository)
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
