<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

use Illuminate\Http\Request;
use App\Repository\PostCategoryRepository;
use App\Repository\PostCategoryDescriptionRepository;
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
     * post category repository instance
     *
     * @var App\Repository\PostCategoryRepository
     */
    protected $repository;

    /**
     * post description repository instance
     *
     * @var App\Repository\PostCategoryDescriptionRepository
     */
    protected $descriptionRepository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\PostCategoryRepository $repository
     * @param App\Repository\PostCategoryDescriptionRepository $descriptionRepository
     */
    public function __construct(
        Request $request, 
        PostCategoryRepository $repository,
        PostCategoryDescriptionRepository $descriptionRepository
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
