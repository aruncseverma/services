<?php

namespace App\Http\Controllers\Admin\Posts;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class MultipleCloneController extends Controller
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
        $postIds = $request->input('ids');
        if (empty($postIds)) {
            $this->notifyError(__('Requested posts to clone is empty'));
            return back();
        }
        $clonePosts = $this->repository->multipleCloneData($postIds);

        // redirect to next request
        return $this->redirectTo($clonePosts, $request);
    }

    /**
     * redirect to next request
     *
     * @param  Collection $clonePosts
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Collection $clonePosts, Request $request): RedirectResponse
    {

        if ($clonePosts->count()) {
            $clonePostIds = $clonePosts->keys()->all();
            $this->notifySuccess(__('Post(s) successfully cloned'));
            return redirect()->route('admin.posts.manage', ['id' => $clonePostIds]);
        }
        $this->notifyError(__('Unable to clone your request. Please try again sometime'));
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
