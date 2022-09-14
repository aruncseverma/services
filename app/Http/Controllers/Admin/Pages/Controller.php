<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Http\Request;
use App\Repository\PostRepository;
use App\Repository\PostDescriptionRepository;
use App\Http\Controllers\Admin\Controller as BaseController;
use App\Models\Post;

abstract class Controller extends BaseController
{
    /**
     * post type
     *
     * @const
     */
    const DEFAULT_TYPE = Post::PAGE_TYPE;

    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * post repository instance
     *
     * @var App\Repository\PostRepository
     */
    protected $repository;

    /**
     * post description repository instance
     *
     * @var App\Repository\PostDescriptionRepository
     */
    protected $descriptionRepository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\PostRepository $repository
     * @param App\Repository\PostDescriptionRepository $descriptionRepository
     */
    public function __construct(
        Request $request, 
        PostRepository $repository,
        PostDescriptionRepository $descriptionRepository
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
