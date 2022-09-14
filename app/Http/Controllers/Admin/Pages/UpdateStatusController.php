<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UpdateStatusController extends Controller
{
    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $post = $this->repository->find($request->get('id'));

        if (!$post) {
            $this->notifyError(__('Requested post does not exists'));
            return back();
        }

        $this->repository->save(['is_active' => !$post->isActive()], $post);

        if ($post->wasChanged('is_active')) {
            $this->notifySuccess(__('Status successfully updated'));
            // remove pagination cache
            $this->repository->removePagePaginationCache($post);
        } else {
            $this->notifyWarning(__('No changes detected'));
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
