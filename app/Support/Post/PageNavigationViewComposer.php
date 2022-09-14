<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Repository\PostRepository;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PageNavigationViewComposer
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
        $langCode = $this->request->get('lang_code', app()->getLocale());
        $parentId = $view->getData()['parent_id'] ?? null;
        $limit  = 0;
        $order  = 'asc';

        $values = [];
        $cacheId = Post::CACHE_ID;
        if (Cache::has($cacheId)) {
            $values = Cache::get($cacheId);
        }
        $cacheKey = !empty($parentId) ? $parentId : 'all';

        if (isset($values[$cacheKey])) {
            $pages = $values[$cacheKey];
        } else {
            $search = array_merge(
                [
                    'title' => null,
                    //'lang_code' => app()->getLocale(),
                    'limit' => $limit,
                    'is_active' => true,
                    'post_type' => Post::PAGE_TYPE,
                    'sort' => 'post_at',
                    'order' => $order,
                    'parent_id' => $parentId,
                    'with_pages' => true,
                ]
            );
            $pages = $this->repository->search($limit, $search, false);
            $values[$cacheKey] = $pages;
            Cache::forever($cacheId, $values);
        }

        $view->with('pages', $pages);
        $view->with('langCode', $langCode);
    }
}
