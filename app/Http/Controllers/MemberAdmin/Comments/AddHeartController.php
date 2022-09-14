<?php

namespace App\Http\Controllers\MemberAdmin\Comments;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;

class AddHeartController extends Controller
{
    /**
     * Request Variable
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * Comment Repository
     *
     * @var CommentRepository
     */
    protected $comentRepo;

    /**
     * User Repository
     *
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * Undocumented function
     *
     * @param Request               $request
     * @param CommentRepository    $comentRepo
     * @param UserRepository    $userRepo
     */
    public function __construct(Request $request, CommentRepository $comentRepo, UserRepository $userRepo)
    {
        $this->request = $request;
        $this->comentRepo = $comentRepo;
        $this->userRepo = $userRepo;

        parent::__construct();
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
        if (!$commentId = $this->request->input('id')) {
            $this->notifyError(__('Add heart requires identifier.'));
            return redirect()->back();
        }

        // validate if data is already exists
        $comment = $this->comentRepo->find($commentId);

        if (!$comment || $comment->user_id != $user->getKey()) {
            $this->notifyWarning(__('Comment not found.'));
            return redirect()->back();
        }

        // update data
        $res = $this->comentRepo->store([
            'is_hearted' => true
        ], $user, $comment);

        // notify next request
        if ($res) {
            $this->notifySuccess(__('Heart added successfully.'));
        } else {
            $this->notifyWarning(__('Unable to process current request. Please try again sometime'));
        }

        return redirect()->back();
    }
}
