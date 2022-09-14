<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PreviewController extends Controller
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
        $id = $request->get('id');
        if (!$id) {
            abort(404);
        }
        $category = $this->repository->find($id);
        if (!$category) {
            abort(404);
        }

        $slugPath = $this->repository->getSlugPath($category);
        // redirect to preview page
        return redirect()->route('index.posts.categories.view', [
            'path' => $slugPath,
        ]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        if ($this->request->has('id')) {
            $this->middleware('can:posts.update');
        } else {
            $this->middleware('can:posts.create');
        }
    }
}
