<?php

namespace App\Http\Controllers\Admin\Posts;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\InteractsWithPostPhotoStorage;

class DeletePhotoController extends Controller
{
    use InteractsWithPostPhotoStorage;

    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $post = $this->repository->find($request->get('id'));
        $photo = $post->featuredPhoto;

        if (empty($photo)) {
            $this->notifyWarning(__('No featured photo found . Please upload some'));
        } else {
            if ($this->deletePostPhoto($photo->path)) {
                // delete to repository
                $this->photoRepository->delete($photo->getKey());
                $this->notifySuccess(__('Featured photo removed successfully'));
            } else {
                $this->notifyWarning(__('Unable to remove featured photo. Please try again sometime'));
            }
        }

        return back()->withInput(['notify' => 'post_photo']);
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
