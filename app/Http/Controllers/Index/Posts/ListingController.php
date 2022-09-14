<?php

namespace App\Http\Controllers\Index\Posts;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repository\PostRepository;
use App\Models\Post;

class ListingController extends BaseController
{
    /**
     * @param Request $request
     * @param PostRepository $postRepo
     * @return void
     */
    public function __construct(Request $request, PostRepository $postRepo)
    {
        $this->request = $request;
        $this->postRepo = $postRepo;
    }

    /**
     * handles incoming request
     *
     * @return View|RedirectResponse
     */
    public function handle()
    {
        $limit = 0;
        $order = 'asc';
        $langCode = $this->request->input('lang_code', app()->getLocale());

        $search = [
            'title' => null,
            'lang_code' => $langCode,
            'limit' => $limit,
            'is_active' => 1, //'*',
            'post_type' => Post::POST_TYPE,
            'sort' => 'post_at',
            'order' => $order,
        ];

        // get posts from repository
        $posts  = $this->postRepo->search($limit, $search, true, false);
        $posts->appends([
            'limit' => $limit,
            'order' => $order,
        ]);

        $this->setTitle(__('Blogs'));
        // $this->setMetaDescription();
        //$this->setMetaKeywords();

        return view('Index::posts.listing', [
            'langCode' => $langCode,
            'posts' => $posts,
            'postRepo' => $this->postRepo,
        ]);
    }
}
