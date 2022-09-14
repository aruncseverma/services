<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

use Illuminate\Http\JsonResponse;

class GetCategoryController extends Controller
{
    /**
     * get category data
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $langCode = $this->request->input('lang_code', app()->getLocale());

        $limit  = 0;
        $search = array_merge(
            [
            ],
            $this->request->query()
        );

        // get post categories from repository
        $categories  = $this->repository->search($limit, $search, false);

        $categoryNames = [];
        foreach($categories as $category) {
            $categoryNames[] = $category->getDescription($langCode, true)->name ?? '';
        }
        return response()->json([
            'status' => 1,
            'data' => implode(', ', $categoryNames),
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
