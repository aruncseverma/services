<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

use App\Models\PostTag;
use App\Models\PostTagDescription;
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

        // requested tag data
       if (empty(old()) && $id) {
            // try fetching the post model from the repository
            $tag = $this->repository->find($id);

            if (!$tag) {
                $this->notifyError(__('Requested data not found'));
                return redirect()->route('admin.posts.tags.create');
            }

            // get description
            $description = $tag->getDescription($langCode, false);
        } else {
            // get post model from old input if necessary
            $tag = $this->getModelFromOldRequest();
            $description = $this->getDescriptionModelFromOldRequest();
        }

        if ($id) {
            $languageUrl = route('admin.posts.tags.update', ['id' => $id]);
        } else {
            $languageUrl = route('admin.posts.tags.create') . '?';
            $languages = $languages->where('code', app()->getLocale());
        }

        // set necessary title for this form
        $this->setTitle(
            ($tag->getKey()) ? __('Update Tag') : __('New Tag')
        );

        return view('Admin::posts.tags.form', [
            'tag' => $tag,
            'description' => $description,
            'languages' => $languages,
            'languageUrl' => $languageUrl,
            'langCode' => $langCode,
        ]);
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\PostTag
     */
    protected function getModelFromOldRequest() : PostTag
    {
        $post = $this->repository->getModel();

        // set post info
        foreach (old('tag', []) as $key => $value) {
            $post->setAttribute($key, $value);
        }

        return $post;
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\PostTagDescription
     */
    protected function getDescriptionModelFromOldRequest(): PostTagDescription
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
        if ($this->request->has('tag.id')) {
            $this->middleware('can:posts.update');
        } else {
            $this->middleware('can:posts.create');
        }
    }
}
