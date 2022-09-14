<?php

namespace App\Http\Controllers\Index\Posts\Categories;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repository\PostCategoryRepository;
use App\Repository\PostCategoryDescriptionRepository;

class RedirectController extends BaseController
{
    /**
     * @param Request $request
     * @param PostCategoryDescriptionRepository $repo
     * @return void
     */
    public function __construct(
        Request $request,
        PostCategoryRepository $repo,
        PostCategoryDescriptionRepository $desc
    ) {
        $this->request = $request;
        $this->repo = $repo;
        $this->desc = $desc;
    }

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $categoryName = $request->get('category_name');
        if (!$categoryName) {
            abort(404);
        }

        $langCode = $request->get('lang_code', app()->getLocale());
        $category = $this->desc->findByCategoryName($categoryName, $langCode);
        if (!$category) {
            abort(404);
        }
        $categoryUrl = $this->repo->getCategoryUrl($category);
        // redirect to preview page
        return redirect($categoryUrl);
    }
}