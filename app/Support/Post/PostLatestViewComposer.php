<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Repository\PostRepository;

class PostLatestViewComposer
{
    /**
     * create instance
     *
     * @param Request $request
     * @param PostRepository $repository
     */
    public function __construct(Request $request, PostRepository $repository)
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
        // get posts from repository
        $posts  = $this->repository->getLatest($limit);
        $view->with('latestPosts', $posts);
        $view->with('langCode', $langCode);
    }
}
