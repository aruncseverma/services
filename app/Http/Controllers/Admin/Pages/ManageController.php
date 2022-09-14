<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Contracts\View\View;
use App\Models\Post;

class ManageController extends Controller
{
    /**
     * create controller view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $this->setTitle(__('Manage Pages'));

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

        $isParentToChild = true;
        if ($search['is_active'] != '*' 
            || !empty($search['title']) 
            || isset($search['published']) 
            || isset($search['pending']) 
            || !empty($search['id'])
            || !empty($search['slug'])
        ) {
            $isParentToChild = false;
            if (array_key_exists('parent_id',  $search) 
                && $search['parent_id'] == null
            ) {
                unset($search['parent_id']);
            }
        }

        if ($isParentToChild) {
            if (!array_key_exists('parent_id',  $search)) {
                $search['parent_id'] = null;
            }
            $search['limit'] = 0;
            $isPaginate = false;
        } else {
            $isPaginate = true;
        }

        // get posts from repository
        $pages  = $this->repository->search($limit, $search, $isPaginate);

        // create view instance
        $view = view('Admin::pages.manage')
            ->with([
                'pages' => $pages,
                'search' => $search,
                'langCode' => app()->getLocale(),
                'totalPosts' => $this->repository->getTotalPosts(Post::PAGE_TYPE),
                'totalPublished' => $this->repository->getTotalPublished(Post::PAGE_TYPE),
                'totalNotPublishYet' => $this->repository->getTotalNotPublishYet(Post::PAGE_TYPE),
                'totalPending' => $this->repository->getTotalPending(Post::PAGE_TYPE),
                'isParentToChild' => $isParentToChild,
                'postRepo' => $this->repository,
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
        $this->middleware('can:pages.manage');
    }
}
