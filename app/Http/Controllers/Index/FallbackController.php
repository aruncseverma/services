<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repository\PostRepository;
use App\Models\Post;

class FallbackController extends BaseController
{
    /**
     * @param Request $request
     * @param PostRepository $postRepo
     * @return void
     */
    public function __construct(
        Request $request,
        PostRepository $postRepo
    ) {
        $this->request = $request;
        $this->postRepo = $postRepo;
    }

    /**
     * handles incoming request
     *
     * @return View|RedirectResponse
     */
    public function handle($path = null)
    {
        if (!is_null($path)) {

            $paths = explode('/', $path);
            $slug = end($paths);
            
            $langCode = $this->request->input('lang_code', app()->getLocale());
            $post = $this->postRepo->findBySlug($slug);
            if (!$post) {
                abort(404);
            }

            // invalid post data, because post type is one slug/path only
            $totalPaths = count($paths);
            if ($totalPaths > 1 && $post->post_type == POST::POST_TYPE) {
                abort(404);
            }

            $admin = $this->getAuthManager()->guard('admin')->user();
            $isValidate = is_null($admin) ? true : false;
            // check if data is page then check if slug path is correct
            if ($post->post_type == Post::PAGE_TYPE) {
                $slugPath = $post->getSlugPath($isValidate);
                // if path is not equal to page slug path
                if ($path != $slugPath
                ) {
                    abort(404);
                }
            }

            // admin can preview inactive post
            // or active but not post yet
            if (!$post->isActive() || ($post->isActive() && !$post->isPosted())) {
                $admin = $this->getAuthManager()->guard('admin')->user();
                if (is_null($admin)) {
                    abort(404);
                }
            }

            // get post description
            $description = $post->getDescription($langCode, true);
            if (is_null($description->post_id)) {
                abort(404);
            }
            $this->setTitle($description->page_title ?? $description->title ?? '');
            $this->setMetaDescription($description->meta_description);
            $this->setMetaKeywords($description->meta_keywords);

            if ($post->post_type == 'page') {
                return view('Index::pages.view', [
                    'page' => $post,
                    'description' => $description,
                    'langCode' => $langCode,
                ]);
            }

            return view('Index::posts.view', [
                'post' => $post,
                'description' => $description,
                'langCode' => $langCode,
                'catIdsNames' => $this->postRepo->getCategoryNamesByCategoryIds($post->category_ids, $langCode, [
                    'is_active' => true,
                ]),
                'tags' => $this->postRepo->getTagsByTagIds($post->tag_ids, [
                    'is_active' => true,
                ]),
                'prevPost' => $post->previous(),
                'nextPost' => $post->next(),
                'totalComments' => $post->totalApprovedComments(),
            ]);
        }

        abort(404);
    }
}