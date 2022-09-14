<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Repository\PostTagRepository;

class TagViewComposer
{
    /**
     * create instance
     *
     * @param Request $request
     * @param PostTagRepository $tagRepo
     */
    public function __construct(Request $request, PostTagRepository $tagRepo)
    {
        $this->request = $request;
        $this->tagRepo = $tagRepo;
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
        $tags = $this->tagRepo->search(0, [], false);

        $view->with('tags', $tags);
    }
}
