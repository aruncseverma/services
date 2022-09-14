<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Http\JsonResponse;

class GetPageController extends Controller
{
    /**
     * get category data
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $langCode = $this->request->input('lang_code', app()->getLocale());
        $pageId = $this->request->input('id');
        $page = null;

        // get page from repository
        if (!$pageId || !($page  = $this->repository->find($pageId))) {
            return response()->json([
                'status' => 0,
                'data' => null,
            ]);
        }

        return response()->json([
            'status' => 1,
            'data' => $page->getDescription($langCode, true)->title ?? '',
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
