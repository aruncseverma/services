<?php

namespace App\Http\Controllers\Admin\Posts;

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
            $post = $this->repository->find($id);
            if (!$post) {
                continue;
            }

            // delete post comments
            $commentRepo->deleteByPostIds($post->getKey());

            // delete post photos
            $photoRepo->deleteByPostIds($post->getKey());

            // delete post descriptions
            $this->descriptionRepository->deleteByPostIds($post->getKey());

            // process delete
            if ($this->repository->delete($id)) {
                ++$affected;
            }
        }

        // redirect to next request
        if (!$affected) {
            $this->notifyWarning(__('Unable to delete post. Please try again later'));
        } else {
            $this->notifySuccess(__('Post(s) successfully deleted.'));
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
