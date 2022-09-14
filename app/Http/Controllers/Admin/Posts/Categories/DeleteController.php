<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

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

        $category = $this->repository->find($id);
        if (!$category) {
            $this->notifyError(__('Requested data not found'));
            return $this->redirectTo();
        }

        $oldParentId = $category->getKey();
        $newParentId = $category->parent_id ?? null;

        // delete category descriptions
        $this->descriptionRepository->deleteByIds($category->getKey());

        // process delete
        $isDeleted = false;
        if ($this->repository->delete($id)) {
            // remove this category to all posts that have this category
            $posts = app(\App\Repository\PostRepository::class);
            $affectedRows = $posts->removeCategoryId($id);

            // update parent_id of sub categories of this category
            $this->repository->updateParentId($oldParentId, $newParentId);

            $this->notifySuccess(__('Delete success.'));
            $isDeleted = true;
        } else {
            $this->notifyWarning(__('Unable to delete category. Please try again later'));
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
            return redirect()->route('admin.posts.categories.manage');
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
