<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Models\Post;
use App\Models\PostDescription;
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

        // requested post data
        // get data from db. if no old input or old input but comes from featured photo form
        if ((empty(old()) || old('notify') == 'post_photo') && $id) {
            // try fetching the post model from the repository
            $post = $this->repository->find($id);

            if (!$post || !$post->isPageType()) {
                $this->notifyError(__('Requested page not found'));
                return redirect()->route('admin.page.create');
            }

            // get description
            $description = $post->getDescription($langCode, false);
        } else {
            // get post model from old input if necessary
            $post = $this->getModelFromOldRequest();
            $description = $this->getDescriptionModelFromOldRequest();
        }

        if ($id) {
            $languageUrl = route('admin.page.update', ['id' => $id]);
        } else {
            $languageUrl = route('admin.page.create') . '?';
            $languages = $languages->where('code', app()->getLocale());
        }

        // set necessary title for this form
        $this->setTitle(
            ($post->getKey()) ? __('Update Page') : __('New Page')
        );

        return view('Admin::pages.form', [
            'post' => $post,
            'description' => $description,
            'languages' => $languages,
            'languageUrl' => $languageUrl,
            'langCode' => $langCode,
        ]);
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\Post
     */
    protected function getModelFromOldRequest() : Post
    {
        $post = $this->repository->getModel();

        // set post info
        foreach (old('post', []) as $key => $value) {
            $post->setAttribute($key, $value);
        }

        return $post;
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\PostDescription
     */
    protected function getDescriptionModelFromOldRequest(): PostDescription
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
        if ($this->request->has('id')) {
            $this->middleware('can:pages.update');
        } else {
            $this->middleware('can:pages.create');
        }
    }
}
