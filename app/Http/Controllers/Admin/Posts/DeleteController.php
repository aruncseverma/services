<?php

namespace App\Http\Controllers\Admin\Posts;

use Illuminate\Http\RedirectResponse;
use App\Repository\PostCommentRepository;
use App\Repository\PostPhotoRepository;

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

        $post = $this->repository->find($id);
        if (!$post) {
            $this->notifyError(__('Requested post not found'));
            return $this->redirectTo();
        }

        $commentRepo = app(PostCommentRepository::class);
        $photoRepo = app(PostPhotoRepository::class);
        // delete post comments
        $commentRepo->deleteByPostIds($post->getKey());
        // delete post photos
        $photoRepo->deleteByPostIds($post->getKey());

        // delete post descriptions
        $this->descriptionRepository->deleteByPostIds($post->getKey());

        // process delete
        if ($this->repository->delete($id)) {
            $this->notifySuccess(__('Delete success.'));
        } else {
            $this->notifyWarning(__('Unable to delete post. Please try again later'));
        }

        return $this->redirectTo();
    }

    /**
     * get redirect url
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(): RedirectResponse
    {
        return redirect()->route('admin.posts.manage');
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
