<?php

namespace App\Http\Controllers\Admin\Posts\Comments;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UpdateStatusController extends Controller
{
    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $comment = $this->commentRepo->find($request->get('id'));

        if (!$comment) {
            $this->notifyError(__('Requested data does not exists'));
            return back();
        }

        $this->commentRepo->save(['is_approved' => !$comment->isApproved()], $comment);

        if ($comment->wasChanged('is_approved')) {
            $this->notifySuccess(__('Status successfully updated'));
        } else {
            $this->notifyWarning(__('No changes detected'));
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
