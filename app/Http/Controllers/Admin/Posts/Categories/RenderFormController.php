<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

use App\Models\PostCategory;
use App\Models\PostCategoryDescription;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsLanguages;

class RenderFormController extends Controller
{
    use NeedsLanguages;

    /**
     * renders form view
     *
     * @param  Illuminate\Http\Request
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view(Request $request)
    {
        $langCode = $request->input('lang_code', app()->getLocale());
        $languages = $this->getLanguages();

        $id = old('id', $request->get('id'));

        // requested category data
        if (empty(old()) && $id) {
            // try fetching the post model from the repository
            $category = $this->repository->find($id);

            if (!$category) {
                $this->notifyError(__('Requested data not found'));
                return redirect()->route('admin.posts.categories.create');
            }

            // get description
            $description = $category->getDescription($langCode, false);
        } else {
            // get post model from old input if necessary
            $category = $this->getModelFromOldRequest();
            $description = $this->getDescriptionModelFromOldRequest();
        }

        if ($id) {
            $languageUrl = route('admin.posts.categories.update', ['id' => $id]);
        } else {
            $languageUrl = route('admin.posts.categories.create') . '?';
            $languages = $languages->where('code', app()->getLocale());
        }

        // set necessary title for this form
        $this->setTitle(
            ($category->getKey()) ? __('Update Category') : __('New Category')
        );

        return view('Admin::posts.categories.form', [
            'category' => $category,
            'description' => $description,
            'languages' => $languages,
            'languageUrl' => $languageUrl,
            'langCode' => $langCode,
        ]);
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\PostCategory
     */
    protected function getModelFromOldRequest() : PostCategory
    {
        $post = $this->repository->getModel();

        // set post info
        foreach (old('category', []) as $key => $value) {
            $post->setAttribute($key, $value);
        }

        return $post;
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\PostCategoryDescription
     */
    protected function getDescriptionModelFromOldRequest(): PostCategoryDescription
    {
        $description = $this->descriptionRepository->getModel();

        // set post description info
        foreach (old('description', []) as $key => $value) {
            $description->setAttribute($key, $value);
        }

        return $description;
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        if ($this->request->has('category.id')) {
            $this->middleware('can:posts.update');
        } else {
            $this->middleware('can:posts.create');
        }
    }
}
