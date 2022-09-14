<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MultipleUpdateStatusController extends Controller
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
            $this->notifyError(__('No data to update status'));
            return back();
        }

        $status = $request->input('status', 1);
        $isActive = $status > 0 ? true : false;

        $affected = 0;
        foreach ($ids as $id) {
            $post = $this->repository->find($id);
            if (!$post) {
                continue;
            }
            // process update status
            $this->repository->save(['is_active' => $isActive], $post);
            if ($post->wasChanged('is_active')) {
                ++$affected;
            }
        }

        // redirect to next request
        if (!$affected) {
            $this->notifyWarning(__('No changes detected'));
        } else {
            $this->notifySuccess(__('Status successfully updated.'));
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
