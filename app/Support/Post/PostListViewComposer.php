<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Repository\PostRepository;
use App\Models\Post;

class PostListViewComposer
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
        $fallLimit = $view->getData()['limit'] ?? 8; // @TODO - $this->getPageSize();
        $fallOrder = $view->getData()['order'] ?? 'asc';
        $categoryId = $view->getData()['category_id'] ?? '';
        $tagId = $view->getData()['tag_id'] ?? '';

        $langCode = $this->request->get('lang_code', app()->getLocale());
        $limit  = $this->request->get('limit', $fallLimit);
        $order  = $this->request->get('order', $fallOrder);
        $search = array_merge(
            [
                'title' => null,
                //'lang_code' => app()->getLocale(),
                'limit' => $limit,
                'is_active' => 1, //'*',
                'post_type' => Post::POST_TYPE,
                'sort' => 'post_at',
                'order' => $order,
                'category_id' => $categoryId,
                'tag_id' => $tagId,
            ],
            $this->request->except(['lang_code', 'category_id']) //$this->request->query()
        );

        // get posts from repository
        $posts  = $this->repository->search($limit, $search, true, false);
        $posts->appends([
            'limit' => $limit,
            'order' => $order,
        ]);

        $view->with('posts', $posts);
        $view->with('postLangCode', $langCode);
        $view->with('postSearch', $search);
        $view->with('postRepo', $this->repository);
    }
}
