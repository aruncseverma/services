<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

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

        $tag = $this->repository->find($id);
        if (!$tag) {
            $this->notifyError(__('Requested data not found'));
            return $this->redirectTo();
        }

        // delete tag descriptions
        $this->descriptionRepository->deleteByIds($tag->getKey());

        // process delete
        $isDeleted = false;
        if ($this->repository->delete($id)) {
            // remove this tag to all posts that have this tag
            $posts = app(\App\Repository\PostRepository::class);
            $affectedRows = $posts->removeTagId($id);

            $this->notifySuccess(__('Delete success.'));
            $isDeleted = true;
        } else {
            $this->notifyWarning(__('Unable to delete tag. Please try again later'));
        }

        return $this->redirectTo($isDeleted);
    }

    /**
     * get redirect url
     *
     * @param bool $isDeleted
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo($isDeleted = false): RedirectResponse
    {
        if ($isDeleted) {
            return redirect()->route('admin.posts.tags.manage');
        }
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
