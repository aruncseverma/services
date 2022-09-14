<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

use Illuminate\Http\Request;
use App\Repository\PostTagRepository;
use App\Repository\PostTagDescriptionRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * post tag repository instance
     *
     * @var App\Repository\PostTagRepository
     */
    protected $repository;

    /**
     * post description repository instance
     *
     * @var App\Repository\PostTagDescriptionRepository
     */
    protected $descriptionRepository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\PostTagRepository $repository
     * @param App\Repository\PostTagDescriptionRepository $descriptionRepository
     */
    public function __construct(
        Request $request, 
        PostTagRepository $repository,
        PostTagDescriptionRepository $descriptionRepository
    ) {
        $this->request = $request;
        $this->repository = $repository;
        $this->descriptionRepository = $descriptionRepository;

        // call middlewares
        $this->attachMiddleware();

        parent::__construct();
    }

    /**
     * attach middleware(s) for this controller
     *
     * @return void
     */
    abstract protected function attachMiddleware(): void;
}
