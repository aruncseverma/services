<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Repository\PostRepository;
use App\Repository\PostCommentRepository;
use App\Support\Concerns\InteractsWithAuth;
use App\Models\Administrator;
use App\Models\Agency;
use App\Models\Escort;
use App\Models\Member;

class CommentViewComposer
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
        $post = $view->getData()['post'] ?? null;
        if (is_null($post) && $postId > 0) {
            $post = $this->postRepo->find($postId);
        }

        $authUser = $this->getAuthUserPriority();
        $authType = null;
        $logoutUrl = route('index.posts.comments.logout_auth');
        $profileUrl = route('index.posts.comments.profile_auth');
        if ($authUser) {
            switch ($authUser->type) {
                case Administrator::USER_TYPE:
                    $authType = 'admin';
                   // $logoutUrl = route('admin.auth.logout');
                    break;
                case Agency::USER_TYPE:
                    $authType = 'agency';
                  //  $logoutUrl = route('agency_admin.auth.logout');
                    break;
                case Escort::USER_TYPE:
                    $authType = 'escort';
                   // $logoutUrl = route('escort_admin.auth.logout');
                    break;
                case Member::USER_TYPE:
                    $authType = 'member';
                   // $logoutUrl = route('member_admin.auth.logout');
                    break;
            }
        }

        
        $view->with('commentAuth', $authUser);
        $view->with('commentAuthType', $authType);
        $view->with('commentLogoutUrl', $logoutUrl);
        $view->with('commentProfileUrl', $profileUrl);

        $showForm = false;
        $showLogin = false;
        if ($post->isAllowedComment()) {
            if (!$post->isAllowedGuestComment() && !$authUser) {
                $showLogin = true;
            } else {
                $showForm = true;
            }
        }

        $view->with('commentShowForm', $showForm);
        $view->with('commentShowLogin', $showLogin);
    }
}
