<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

use Illuminate\Http\JsonResponse;

class GetCategoriesController extends Controller
{
    /**
     * get categories
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $limit  = 0;
        $search = array_merge(
            [
                'name' => null,
                //'lang_code' => app()->getLocale(),
                'limit' => $limit,
                'is_active' => '*',
                'parent_id' => null,
            ],
            $this->request->query()
        );

        // get post categories from repository
        $categories  = $this->repository->search($limit, $search, false);

        $html = view('Admin::posts.categories.components.list')
            ->with([
                'categories' => $categories,
                'search' => $search,
                'langCode' => app()->getLocale(),
                'except_id' => $this->request->get('except_id'),
                'current_id' => $this->request->get('current_id'),
                'is_multiple' => $this->request->get('is_multiple', 0),
                'hide_option' => $this->request->get('hide_option', 0),
            ])->render();

        return response()->json([
            'html' => $html,
        ]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        $this->middleware('can:posts.update');
        $this->middleware('can:posts.create');
    }
}
