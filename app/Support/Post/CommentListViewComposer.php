<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Repository\PostRepository;
use App\Repository\PostCommentRepository;
use App\Support\Concerns\InteractsWithAuth;

class CommentListViewComposer
{
    use InteractsWithAuth;

    /**
     * create instance
     *
     * @param Request $request
     * @param PostRepository $postRepo
     * @param PostCommentRepository $commentRepo
     */
    public function __construct(
        Request $request, 
        PostRepository $postRepo,
        PostCommentRepository $commentRepo
    ) {
        $this->request = $request;
        $this->postRepo = $postRepo;
        $this->commentRepo = $commentRepo;
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
        $postId = $view->getData()['post_id'] ?? null;
        $parentId = $view->getData()['parent_id'] ?? null;
        $displayPendingId = $view->getData()['display_pending_id'] ?? null;

        $currentAuthUser = $this->getAuthUserPriority();

        $search = array_merge(
            [
                'is_approved' => 1,
                'post_id' => $postId,
                'parent_id' => $parentId,
                'display_pending_id' => $displayPendingId,
                'comment_user_id' => $currentAuthUser ? $currentAuthUser->getKey() : null,
            ],
            $this->request->except(['post_id', 'parent_id'])
        );

        // get posts from repository
        $limit = 0;
        $isPaginate = false;
        $isAppendParamToPaginate = false;
        $comments = $this->commentRepo->search($limit, $search, $isPaginate, $isAppendParamToPaginate);

        $view->with('postId', $postId);
        $view->with('comments', $comments);
        $view->with('commentAuth', $currentAuthUser);
    }
}
