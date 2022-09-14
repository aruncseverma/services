<?php

namespace App\Http\Controllers\Index\Posts\Tags;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repository\PostTagRepository;

class ViewController extends BaseController
{
    /**
     * @param Request $request
     * @param PostTagRepository $repo
     * @return void
     */
    public function __construct(
        Request $request,
        PostTagRepository $repo
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

        $tag = $this->repo->findBy([
            'slug' => $path
        ]);
        if (!$tag) {
            abort(404);
        }

        if (!$tag->isActive()) {
            // admin can preview inactive post category
            $admin = $this->getAuthManager()->guard('admin')->user();
            if (is_null($admin)) {
                abort(404);
            }
        }

        $langCode = $this->request->input('lang_code', app()->getLocale());
        $description = $tag->getDescription($langCode, true);
        
        $this->setTitle($description->name);

        return view('Index::posts.tags.view', [
            'tag' => $tag,
            'description' => $description,
            'langCode' => $langCode,
        ]);
    }
}