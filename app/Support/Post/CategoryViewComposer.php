<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Repository\PostRepository;
use App\Repository\PostCategoryRepository;

class CategoryViewComposer
{
    /**
     * create instance
     *
     * @param Request $request
     * @param PostRepository $postRepo
     * @param PostCategoryRepository $catRepo
     */
    public function __construct(Request $request, PostRepository $postRepo, PostCategoryRepository $catRepo)
    {
        $this->request = $request;
        $this->postRepo = $postRepo;
        $this->catRepo = $catRepo;
    }

    /**
     * compose template
     *
     * @param  Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $limit = 0;
        $langCode = $this->request->get('lang_code', app()->getLocale());

        $catIds = $this->postRepo->getCategoryIdsUsed();

        $categories = null;
        if (!empty($catIds)) {
            $search = array_merge(
                [
                    'is_active' => true,
                    'id' => $catIds,
                ]
            );
            // get categories from repository
            $categories  = $this->catRepo->search($limit, $search, false);
        }

        $view->with('categories', $categories);
        $view->with('langCode', $langCode);
    }
}
