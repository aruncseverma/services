<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

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
        $category = $this->repository->find($request->get('id'));

        if (!$category) {
            $this->notifyError(__('Requested data does not exists'));
            return back();
        }

        $this->repository->save(['is_active' => !$category->isActive()], $category);

        if ($category->wasChanged('is_active')) {
            $this->notifySuccess(__('Status successfully updated'));
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
        $this->middleware('can:posts.manage');
    }
}
