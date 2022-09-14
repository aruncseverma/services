<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Http\JsonResponse;
use App\Models\Post;

class GetPagesController extends Controller
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
                'post_type' => Post::PAGE_TYPE
            ],
            $this->request->query()
        );

        // get pages from repository
        $pages  = $this->repository->search($limit, $search, false);

        $html = view('Admin::pages.components.list')
            ->with([
                'pages' => $pages,
                'search' => $search,
                'langCode' => app()->getLocale(),
                'except_id' => $this->request->get('except_id'),
                'current_id' => $this->request->get('current_id'),
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
        $this->middleware('can:pages.update');
        $this->middleware('can:pages.create');
    }
}
