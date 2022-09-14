<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Models\Post;
use App\Models\PostDescription;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsLanguages;
use App\Repository\PostTagRepository;
use Illuminate\Support\Collection;
use Carbon\Carbon;

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
        if (empty(old()) && $id) {
            // try fetching the post model from the repository
            $post = $this->repository->find($id);

            if (!$post || !$post->isPostType()) {
                $this->notifyError(__('Requested post not found'));
                return redirect()->route('admin.post.create');
            }

            // get description
            $description = $post->getDescription($langCode, false);
        } else {
            // get post model from old input if necessary
            $post = $this->getModelFromOldRequest();
            $description = $this->getDescriptionModelFromOldRequest();
        }

        if ($id) {
            $languageUrl = route('admin.post.update', ['id' => $id]);
        } else {
            $languageUrl = route('admin.post.create') . '?';
            $languages = $languages->where('code', app()->getLocale());
        }

        // set necessary title for this form
        $this->setTitle(
            ($post->getKey()) ? __('Update Post') : __('New Post')
        );

        return view('Admin::posts.form', [
            'post' => $post,
            'description' => $description,
            'languages' => $languages,
            'languageUrl' => $languageUrl,
            'langCode' => $langCode,
            'tags' => $this->getTags(),
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
        $post->setAttribute('post_at', Carbon::now()->format('m/d/Y h:i A'));
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
            $this->middleware('can:posts.update');
        } else {
            $this->middleware('can:posts.create');
        }
    }

    /**
     * Get tags
     * 
     * @return Collection
     */
    protected function getTags() : Collection
    {
        $repository = app(PostTagRepository::class);
        return $repository->search(0, [], false);
    }
}
