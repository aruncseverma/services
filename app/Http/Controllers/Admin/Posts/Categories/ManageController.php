<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

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
        $this->setTitle(__('Manage Categories'));

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

        $isParentToChild = true;
        if (
            $search['is_active'] != '*'
            || !empty($search['name'])
            || !empty($search['slug'])
        ) {
            $isParentToChild = false;
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

        // get post categories from repository
        $categories  = $this->repository->search($limit, $search, $isPaginate);

        // create view instance
        $view = view('Admin::posts.categories.manage')
            ->with([
                'categories' => $categories,
                'search' => $search,
                'langCode' => app()->getLocale(),
                'totalCategories' => $this->repository->getTotalCategories(),
                'totalActiveCategories' => $this->repository->getTotalActiveCategories(),
                'totalInactiveCategories' => $this->repository->getTotalInactiveCategories(),
                'isParentToChild' => $isParentToChild,
                'catRepo' => $this->repository,
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
