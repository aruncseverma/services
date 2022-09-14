<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsLanguages;
use Illuminate\Validation\Rule;

class SaveController extends Controller
{
    use NeedsLanguages;

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $category = null;

        if ($id = $request->input('category.id')) {
            // get category requested from repository
            $category = $this->repository->find($id);

            if (!$category) {
                $this->notifyError(__('Requested data is invalid'));
                return back();
            }
        }

        // validate
        $this->validateRequest($request, $category);

        // push to repository
        $category = $this->saveData($request, $category);

        // redirect to next request
        return $this->redirectTo($category, $request);
    }

    /**
     * validates incoming request data
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\PostCategory $category
     * 
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest(Request $request, PostCategory $category = null): void
    {
        $rules = [
            'category.is_active'   => 'boolean',
            'description.name' => ['required', 'max:255'],
            'description.lang_code' => 'required',
            'category.parent_id' => ['nullable', Rule::exists($this->repository->getTable(), 'id')],
        ];

        $customAttributes = [
            'category.is_active'   => 'Status',
            'description.name' => 'Name',
            'description.lang_code' => 'Language',
            'category.parent_id' => 'Parent Category',
        ];

        // create unique rule
        $langCode = $request->input('description.lang_code', app()->getLocale());
        $uniqueName = Rule::unique($this->descriptionRepository->getTable(), 'name')
            ->where(function ($query) use ($langCode) {
                return $query->where('lang_code', $langCode);
            });

        // append additional rules
        if (!is_null($category)) {
            // appends ignore current model to be updated
            $uniqueName->ignore($category->getKey(), 'category_id');
        }
        $rules['description.name'][] = $uniqueName;

        $this->validate(
            $request,
            $rules,
            [],
            $customAttributes
        );
    }

    /**
     * save data to repository
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\PostCategory $category
     *
     * @return null|App\Models\PostCategory
     */
    protected function saveData(Request $request, PostCategory $category = null)
    {
        $attributes = [
            'slug' => $request->input('category.slug') ?? $request->input('description.name'),
            'is_active' => $request->input('category.is_active', false),
            'parent_id' => $request->input('category.parent_id')
        ];

        // save data to the repository
        $category = $this->repository->store($attributes, $category);

        if (!$category) {
            return;
        }

        $langRepository = $this->getLanguageRepository();
        $code = $request->input('description.lang_code', '');
        $language = $langRepository->findByCode($code);

        if ($language) {
            $this->descriptionRepository->store(
                [
                    'name' => $request->input('description.name', ''),
                    'description' => $request->input('description.description', ''),
                ],
                $language,
                $category,
                $category->getDescription($code, false)
            );
        }

        return $category;
    }

    /**
     * redirect to next request
     *
     * @param  App\Models\PostCategory $category
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(PostCategory $category = null, Request $request): RedirectResponse
    {
        if (is_null($category)) {
            $this->notifyError(__('Unable to save your request. Please try again sometime'));
        } else {
            $this->notifySuccess(__('Category successfully saved'));
        }

        $langCode = $request->input('description.lang_code');
        return redirect()->route('admin.posts.categories.update', ['id' => $category->getKey(), 'lang_code' => $langCode]);
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
