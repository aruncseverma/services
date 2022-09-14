<?php

namespace App\Http\Controllers\Admin\Posts\Comments;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MultipleDeleteController extends Controller
{
    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $ids = $request->input('ids');
        if (!$ids) {
            $this->notifyError(__('No data to delete'));
            return back();
        }

        $affected = 0;
        foreach($ids as $id) {
            $comment = $this->commentRepo->find($id);
            if (!$comment) {
                continue;
            }

            $replies = $comment->comments;
            // process delete
            if ($this->commentRepo->delete($id)) {
                // delete all replies
                if ($replies) {
                    $affectedRows = $this->commentRepo->deleteReplies($replies);
                }
                ++$affected;
            }
        }

        // redirect to next request
        if (!$affected) {
            $this->notifyWarning(__('Unable to delete comment. Please try again later'));
        } else {
            $this->notifySuccess(__('Comment(s) successfully deleted.'));
        }

        return back();
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
