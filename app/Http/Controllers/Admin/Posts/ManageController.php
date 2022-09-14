<?php

namespace App\Http\Controllers\Admin\Posts;

use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * create controller view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $langCode = app()->getLocale();

        $this->setTitle(__('Manage Posts'));

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'title' => null,
                //'lang_code' => app()->getLocale(),
                'limit' => $limit,
                'is_active' => '*',
                'post_type' => self::DEFAULT_TYPE,
                'slug' => null,
                'author' => null,
            ],
            $this->request->query()
        );

        // get posts from repository
        $posts  = $this->repository->search($limit, $search);

        // create view instance
        $view = view('Admin::posts.manage')
            ->with([
                'posts' => $posts,
                'search' => $search,
                'langCode' => $langCode,
                'catIdsNames' => $this->repository->getCategoryIdsNames($posts, $langCode),
                'tagIdsNames' => $this->repository->getTagIdsNames($posts, $langCode),
                'totalPosts' => $this->repository->getTotalPosts(),
                'totalPublished' => $this->repository->getTotalPublished(),
                'totalNotPublishYet' => $this->repository->getTotalNotPublishYet(),
                'totalPending' => $this->repository->getTotalPending(),
            ]);

        return $view;
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        $this->middleware('can:posts.manage');
    }
}
