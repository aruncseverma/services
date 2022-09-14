<?php

namespace App\Http\Controllers\MemberAdmin\Comments;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\CommentRepository;

class RemoveController extends Controller
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * favorite repository instance
     *
     * @var App\Repository\CommentRepository
     */
    protected $commentRepo;

    /**
     * create instance of this controller
     *
     * @param Request               $request
     * @param CommentRepository    $commentRepo
     */
    public function __construct(
        Request $request,
        CommentRepository $commentRepo
    ) {
        $this->request = $request;
        $this->commentRepo = $commentRepo;
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(): RedirectResponse
    {
        $user = $this->getAuthUser();

        // notify and redirect if does not have any identifier
        if (!$id = $this->request->input('id')) {
            $this->notifyError(__('Remove comment requires identifier.'));
            return redirect()->back();
        }

        $comment = $this->commentRepo->find($id);
        if (!$comment || $comment->user_id != $user->getKey()) {
            $this->notifyError(__('Comment not found.'));
            return redirect()->back();
        }

        // save data
        $res = $this->commentRepo->delete($comment->getKey());

        // notify next request
        if ($res) {
            $this->notifySuccess(__('Removed Successfully.'));
        } else {
            $this->notifyWarning(__('Unable to remove comment request. Please try again sometime'));
        }

        return redirect()->back();
    }
}
