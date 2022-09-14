<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

use App\Models\PostTag;
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
        $tag = null;

        if ($id = $request->input('tag.id')) {
            // get tag requested from repository
            $tag = $this->repository->find($id);

            if (!$tag) {
                $this->notifyError(__('Requested data is invalid'));
                return back();
            }
        }

        // validate
        $this->validateRequest($request, $tag);

        // push to repository
        $tag = $this->saveData($request, $tag);

        // redirect to next request
        return $this->redirectTo($tag, $request);
    }

    /**
     * validates incoming request data
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\PostTag $tag
     * 
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest(Request $request, PostTag $tag = null): void
    {
        $rules = [
            'tag.is_active'   => 'boolean',
            'description.name' => ['required', 'max:255'],
            'description.lang_code' => 'required',
        ];

        $customAttributes = [
            'tag.is_active'   => 'Status',
            'description.name' => 'Name',
            'description.lang_code' => 'Language',
        ];

        // create unique rule
        $langCode = $request->input('description.lang_code', app()->getLocale());
        $uniqueName = Rule::unique($this->descriptionRepository->getTable(), 'name')
            ->where(function ($query) use ($langCode) {
                return $query->where('lang_code', $langCode);
            });

        // append additional rules
        if (!is_null($tag)) {
            // appends ignore current model to be updated
            $uniqueName->ignore($tag->getKey(), 'tag_id');
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
     * @param  App\Models\PostTag $tag
     *
     * @return null|App\Models\PostTag
     */
    protected function saveData(Request $request, PostTag $tag = null)
    {
        $attributes = [
            'slug' => $request->input('tag.slug') ?? $request->input('description.name'),
            'is_active' => $request->input('tag.is_active', false),
        ];

        // save data to the repository
        $tag = $this->repository->store($attributes, $tag);

        if (!$tag) {
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
                $tag,
                $tag->getDescription($code, false)
            );
        }

        return $tag;
    }

    /**
     * redirect to next request
     *
     * @param  App\Models\PostTag $tag
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(PostTag $tag = null, Request $request): RedirectResponse
    {
        if (is_null($tag)) {
            $this->notifyError(__('Unable to save your request. Please try again sometime'));
        } else {
            $this->notifySuccess(__('Tag successfully saved'));
        }

        $langCode = $request->input('description.lang_code');
        return redirect()->route('admin.posts.tags.update', ['id' => $tag->getKey(), 'lang_code' => $langCode]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        if ($this->request->has('tag.id')) {
            $this->middleware('can:posts.update');
        } else {
            $this->middleware('can:posts.create');
        }
    }
}
