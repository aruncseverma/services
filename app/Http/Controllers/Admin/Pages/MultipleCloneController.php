<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class MultipleCloneController extends Controller
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
        $pageIds = $request->input('ids');
        if (empty($pageIds)) {
            $this->notifyError(__('Requested pages to clone is empty'));
            return back();
        }
        $clonePages = $this->repository->multipleCloneData($pageIds);

        // redirect to next request
        return $this->redirectTo($clonePages, $request);
    }

    /**
     * redirect to next request
     *
     * @param  Collection $clonePages
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Collection $clonePages, Request $request): RedirectResponse
    {

        if ($clonePages->count()) {
            $clonePageIds = $clonePages->keys()->all();
            $this->notifySuccess(__('Pages(s) successfully cloned'));
            return redirect()->route('admin.pages.manage', ['id' => $clonePageIds]);
        }
        $this->notifyError(__('Unable to clone your request. Please try again sometime'));
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
