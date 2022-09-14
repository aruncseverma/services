<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

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

        $postRepo = app(\App\Repository\PostRepository::class);

        $affected = 0;
        foreach($ids as $id) {
            $category = $this->repository->find($id);
            if (!$category) {
                continue;
            }

            // delete tag descriptions
            $this->descriptionRepository->deleteByIds($category->getKey());

            // process delete
            if ($this->repository->delete($id)) {
                // remove this tag to all posts that have this tag
                $affectedRows = $postRepo->removeTagId($id);
                ++$affected;
            }
        }

        // redirect to next request
        if (!$affected) {
            $this->notifyWarning(__('Unable to delete post tag. Please try again later'));
        } else {
            $this->notifySuccess(__('Post tag(s) successfully deleted.'));
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
