<?php

namespace App\Http\Controllers\Index\Posts\Categories;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repository\PostCategoryRepository;

class ViewController extends BaseController
{
    /**
     * @param Request $request
     * @param PostCategoryRepository $repo
     * @return void
     */
    public function __construct(
        Request $request,
        PostCategoryRepository $repo
    ) {
        $this->request = $request;
        $this->repo = $repo;
    }

    /**
     * handles incoming request
     *
     * @param string $path
     * @param Request $request
     * 
     * @return View|RedirectResponse
     */
    public function handle($path = null, Request $request)
    {
        if (is_null($path)) {
            abort(404);
        }

        $paths = explode('/', $path);
        $slug = end($paths);

        $category = $this->repo->findBy([
            'slug' => $slug
        ]);
        if (!$category) {
            abort(404);
        }
        // admin can preview inactive post category
        $admin = $this->getAuthManager()->guard('admin')->user();
        $validate = is_null($admin);
        $slugPath = $this->repo->getSlugPath($category, $validate);

        // if path not equal to category slug path
        if ($path != $slugPath) {
            abort(404);
        }

        if (!$category->isActive() && is_null($admin)) {
            abort(404);
        }

        $langCode = $this->request->input('lang_code', app()->getLocale());
        $description = $category->getDescription($langCode, true);
        
        $this->setTitle($description->name);

        return view('Index::posts.categories.view', [
            'category' => $category,
            'description' => $description,
            'langCode' => $langCode,
        ]);
    }
}