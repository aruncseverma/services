<?php

namespace App\Http\Controllers\Admin\Posts\Comments;

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
        if (!$postId = $this->request->get('post_id')) {
            abort(404);
        }

        $post = $this->postRepo->find($postId);
        if (!$post) {
            abort(404);
        }

        $langCode = $this->request->get('lang_code', app()->getLocale());
        $this->setTitle(__('Comments on “' . $post->getDescription($langCode, true)->title . '”'));

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'post_id' => $postId,
                'content' => null,
                'limit' => $limit,
                'is_approved' => '*',
            ],
            $this->request->except(['post_id'])
        );

        // to get author comments
        if (!empty($search['get_mine'])) {
            $search['user_id'] = $post->user_id;
        }
        // get post comments from repository
        $comments  = $this->commentRepo->search($limit, $search, true, false);
        $comments->appends(array_except($search, ['user_id']));

        // create view instance
        $view = view('Admin::posts.comments.manage')
            ->with([
                'post' => $post,
                'comments' => $comments,
                'search' => $search,
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
