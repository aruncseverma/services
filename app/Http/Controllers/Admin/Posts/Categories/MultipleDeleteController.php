<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

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

            $oldParentId = $category->getKey();
            $newParentId = $category->parent_id ?? null;

            // delete category descriptions
            $this->descriptionRepository->deleteByIds($category->getKey());

            // process delete
            if ($this->repository->delete($id)) {
                // remove this category to all posts that have this category
                $affectedRows = $postRepo->removeCategoryId($id);

                // update parent_id of sub categories of this category
                $this->repository->updateParentId($oldParentId, $newParentId);

                ++$affected;
            }
        }

        // redirect to next request
        if (!$affected) {
            $this->notifyWarning(__('Unable to delete post category. Please try again later'));
        } else {
            $this->notifySuccess(__('Post categories successfully deleted.'));
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
