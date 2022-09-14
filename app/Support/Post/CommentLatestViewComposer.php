<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Repository\PostCommentRepository;

class CommentLatestViewComposer
{
    /**
     * create instance
     *
     * @param Request $request
     * @param PostCommentRepository $repository
     */
    public function __construct(Request $request, PostCommentRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * compose template
     *
     * @param  Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $limit = $view->getData()['limit'] ?? 5;
        $langCode = $this->request->get('lang_code', app()->getLocale());
        // get comments from repository
        $comments  = $this->repository->getLatest($limit);
        $view->with('latestComments', $comments);
        $view->with('langCode', $langCode);
    }
}
