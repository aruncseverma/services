<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Repository\PostCommentRepository;
use App\Repository\PostPhotoRepository;

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

        $commentRepo = app(PostCommentRepository::class);
        $photoRepo = app(PostPhotoRepository::class);

        $affected = 0;
        foreach($ids as $id) {
            $page = $this->repository->find($id);
            if (!$page) {
                continue;
            }

            // delete page comments
            $commentRepo->deleteByPostIds($page->getKey());

            // delete page photos
            $photoRepo->deleteByPostIds($page->getKey());

            // delete page descriptions
            $this->descriptionRepository->deleteByPostIds($page->getKey());

            $oldParentId = $page->getKey();
            $newParentId = $page->parent_id ?? null;
            // process delete
            if ($this->repository->delete($id)) {
                // update parent_id of sub categories of this category
                $this->repository->updateParentId($oldParentId, $newParentId);
                // remove pagination cache
                $this->repository->removePagePaginationCache($page);
                ++$affected;
            }
        }

        // redirect to next request
        if (!$affected) {
            $this->notifyWarning(__('Unable to delete page. Please try again later'));
        } else {
            $this->notifySuccess(__('Page(s) successfully deleted.'));
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
        $this->middleware('can:pages.manage');
    }
}
