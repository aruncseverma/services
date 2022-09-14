<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CloneController extends Controller
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
        $id = $request->input('id');
        if (!($id = $request->input('id'))
            || !($post = $this->repository->find($id)) // get post requested from repository
        ) {
            $this->notifyError(__('Requested post to clone is invalid'));
            return back();
        }

        // push to repository
        $clonePost = $this->repository->cloneData($post);

        // redirect to next request
        return $this->redirectTo($clonePost, $request);
    }

    /**
     * redirect to next request
     *
     * @param  App\Models\Post $clonePost
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Post $clonePost = null, Request $request): RedirectResponse
    {
        if (is_null($clonePost)) {
            $this->notifyError(__('Unable to clone your request. Please try again sometime'));
        } else {
            $this->notifySuccess(__('Post successfully cloned'));
        }

        return redirect()->route('admin.post.update', ['id' => $clonePost->getKey()]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        $this->middleware('can:posts.update');
    }
}
