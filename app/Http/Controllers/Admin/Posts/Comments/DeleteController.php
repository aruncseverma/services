<?php

namespace App\Http\Controllers\Admin\Posts\Comments;

use Illuminate\Http\RedirectResponse;

class DeleteController extends Controller
{
    /**
     * handles incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(): RedirectResponse
    {
        // notify and redirect if does not have any identifier
        if (!$id = $this->request->input('id')) {
            $this->notifyError(__('Delete requires identifier.'));
            return $this->redirectTo();
        }

        $comment = $this->commentRepo->find($id);
        if (!$comment) {
            $this->notifyError(__('Requested data not found'));
            return $this->redirectTo();
        }

        $replies = $comment->comments;
        // process delete
        if ($comment->delete()) {
            // delete all replies
            if ($replies) {
                $affectedRows = $this->commentRepo->deleteReplies($replies);
            }
            $this->notifySuccess(__('Delete success.'));
        } else {
            $this->notifyWarning(__('Unable to delete comment. Please try again later'));
        }

        return $this->redirectTo();
    }

    /**
     * get redirect url
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(): RedirectResponse
    {
        return redirect()->back();
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
