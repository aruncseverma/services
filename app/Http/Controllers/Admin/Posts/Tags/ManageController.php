<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

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
        $this->setTitle(__('Manage Tags'));

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'name' => null,
                //'lang_code' => app()->getLocale(),
                'limit' => $limit,
                'is_active' => '*',
                'slug' => null,
            ],
            $this->request->query()
        );

        // get post tags from repository
        $tags  = $this->repository->search($limit, $search);

        // create view instance
        $view = view('Admin::posts.tags.manage')
            ->with([
                'tags' => $tags,
                'search' => $search,
                'langCode' => app()->getLocale(),
                'totalTags' => $this->repository->getTotalTags(),
                'totalActiveTags' => $this->repository->getTotalActiveTags(),
                'totalInactiveTags' => $this->repository->getTotalInactiveTags(),
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
