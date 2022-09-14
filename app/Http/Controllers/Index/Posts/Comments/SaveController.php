<?php

namespace App\Http\Controllers\Index\Posts\Comments;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repository\PostCommentRepository;
use App\Repository\PostRepository;
use Illuminate\Validation\Rule;
use App\Models\PostComment;
use App\Models\Administrator;
use App\Models\Agency;

class SaveController extends BaseController
{
    /**
     * Current auth
     */
    protected $currentAuth = null;

    /**
     * @param PostCommentRepository $commentRepo,
     * @param PostRepository $postRepo
     * @return void
     */
    public function __construct(
        PostCommentRepository $commentRepo,
        PostRepository $postRepo
    ) {
        $this->commentRepo = $commentRepo;
        $this->postRepo = $postRepo;
    }

    /**
     * handles incoming request
     *
     * @param Request $request
     * 
     * @return RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $this->currentAuth = $this->getAuthUserPriority();

        $comment = null;

        // if ($id = $request->input('comment.comment_id')) {
        //     // get category requested from repository
        //     $comment = $this->commentRepo->find($id);

        //     if (!$comment) {
        //         $this->notifyError(__('Requested data is invalid'));
        //         return back();
        //     }
        // }

        // validate
        $this->validateRequest($request, $comment);

        // push to repository
        $comment = $this->saveData($request, $comment);

        // redirect to next request
        return $this->redirectTo($comment, $request);
    }

    /**
     * validates incoming request data
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\PostComment $comment
     * 
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest(Request $request, PostComment $comment = null): void
    {
        $rules = [
            'comment.post_id'   => ['required', Rule::exists($this->postRepo->getTable(), 'id')],
            'comment.parent_id' => ['nullable', Rule::exists($this->commentRepo->getTable(), 'id')],
            'comment.content' => ['required'],
        ];

        if (!$this->currentAuth) {
            $rules = array_merge($rules, [
                'comment.name' => ['required', 'max:255'],
                'comment.email' => ['required', 'email'],
                'comment.url' => ['nullable', 'url'],
            ]);
        }

        $customAttributes = [
            'comment.post_id'   => 'Post',
            'comment.content'   => 'Content',
            'comment.name' => 'Name',
            'comment.email' => 'Email',
            'comment.url' => 'Website',
            'comment.parent_id' => 'Parent',
        ];

        $this->validate(
            $request,
            $rules,
            [],
            $customAttributes
        );
    }

    /**
     * save data to repository
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\PostComment $comment
     *
     * @return null|App\Models\PostComment
     */
    protected function saveData(Request $request, PostComment $comment = null)
    {
        $isApproved = false;
        if (!$this->currentAuth) {
            $name = $request->input('comment.name');
            $email = $request->input('comment.email');
            $url = $request->input('comment.url');
            $userId = null;
        } else {
            $name = $this->currentAuth->name;
            $email = $this->currentAuth->email;
            $url = '';
            if($this->currentAuth->type == Administrator::USER_TYPE) {
                $url = url('/');
            } elseif($this->currentAuth->type == Agency::USER_TYPE) {
                $url = $this->currentAuth->userData->website ?? '';
            }
            $userId = $this->currentAuth->getKey();

            $post = $this->postRepo->find($request->input('comment.post_id'));
            if ($post->user_id = $this->currentAuth->getKey()) {
                $isApproved = true;
            }
        }

        $ipAddress = $request->ip();
        $ua = $request->server('HTTP_USER_AGENT') ?? $request->header('User-Agent');
        $attributes = [
            'post_id' => $request->input('comment.post_id'),
            'content' => $request->input('comment.content'),
            'is_approved' => $isApproved,
            'parent_id' => $request->input('comment.parent_id'),
            'user_id' => $userId,
            'name' => $name,
            'email' => $email,
            'url' => $url,
            'ip' => $ipAddress,
            'agent' => $ua,
        ];

        // save data to the repository
        $comment = $this->commentRepo->store($attributes, $comment);

        if (!$comment) {
            return;
        }

        return $comment;
    }

    /**
     * redirect to next request
     *
     * @param  App\Models\PostComment $comment
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(PostComment $comment = null, Request $request): RedirectResponse
    {
        if (is_null($comment)) {
            $this->notifyError(__('Unable to save your request. Please try again sometime'));
            return redirect()->back();
        } else {
            //$this->notifySuccess(__('Comment successfully saved'));
            $guestCommentId = $this->currentAuth ? null : $comment->getKey();
            return redirect(url()->previous() . '#comment-' . $comment->getKey())->withInput(['guest_comment_id' => $guestCommentId]);
        }
    }
}
