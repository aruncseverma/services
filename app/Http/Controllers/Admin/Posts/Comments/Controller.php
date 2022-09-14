<?php

namespace App\Http\Controllers\Admin\Posts\Comments;

use Illuminate\Http\Request;
use App\Repository\PostCommentRepository;
use App\Repository\PostRepository;
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
     * post comment repository instance
     *
     * @var App\Repository\PostCommentRepository
     */
    protected $commentRepo;

    /**
     * post comment repository instance
     *
     * @var App\Repository\PostRepository
     */
    protected $postRepo;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\PostCommentRepository $commentRepo
     * @param App\Repository\PostRepository $postRepo
     */
    public function __construct(
        Request $request, 
        PostCommentRepository $commentRepo,
        PostRepository $postRepo
    ) {
        $this->request = $request;
        $this->commentRepo = $commentRepo;
        $this->postRepo = $postRepo;

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
