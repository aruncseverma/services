<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Models\Post;
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
        $post = null;

        if ($id = $request->input('post.id')) {
            // get post requested from repository
            $post = $this->repository->find($id);

            if (!$post) {
                $this->notifyError(__('Requested page is invalid'));
                return back();
            }
        }

        // validate
        $this->validateRequest($request, $post);

        // push to repository
        $post = $this->savePost($request, $post);

        // redirect to next request
        return $this->redirectTo($post, $request);
    }

    /**
     * validates incoming request data
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Post $post
     * 
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest(Request $request, Post $post = null): void
    {
        $rules = [
            //'post.slug' => ['required'],
            'post.is_active'   => 'boolean',
            'description.title' => ['required', 'max:255'],
            'description.lang_code' => 'required',
            'description.content' => 'required',
            //'description.meta_description' => 'required',
            //'description.meta_keywords' => 'required',
            'post.allow_comment'   => 'boolean',
            'post.allow_guest_comment'   => 'boolean',
            'post.parent_id' => ['nullable', Rule::exists($this->repository->getTable(), 'id')],
        ];

        $customAttributes = [
            'post.slug' => 'Slug',
            'post.is_active'   => 'Status',
            'post.post_at'   => 'Date',
            'description.title' => 'Title',
            'description.lang_code' => 'Language',
            'description.content' => 'Content',
            'post.allow_comment'   => 'Allow comment',
            'post.allow_guest_comment'   => 'Allow guests to comment',
            'post.parent_id' => 'Parent Page',
        ];

        $langCode = $request->input('description.lang_code', app()->getLocale());

        $postType = self::DEFAULT_TYPE;
        $postId = $request->input('post.id');
        $uniqueTitle = function ($attribute, $value, $fail) use ($langCode, $postType, $postId) {
            if (!$this->repository->isUniqueTitle($value, $langCode, $postType, $postId)) {
                return $fail('The Title has already been taken.');
            }
        };

        $rules['description.title'][] = $uniqueTitle;

        $this->validate(
            $request,
            $rules,
            [],
            $customAttributes
        );
    }

    /**
     * save post to repository
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Post $post
     *
     * @return null|App\Models\Post
     */
    protected function savePost(Request $request, Post $post = null)
    {
        $attributes = [
            'user_id' => $this->getAuthUser()->getKey(),
            'slug' => $request->input('post.slug') ?? $request->input('description.title'),
            'is_active' => $request->input('post.is_active', false),
            'post_at' => $request->input('post.post_at'),
            'post_type' => self::DEFAULT_TYPE,
            'allow_comment' => $request->input('post.allow_comment', false),
            'allow_guest_comment' => $request->input('post.allow_guest_comment', false),
            'parent_id' => $request->input('post.parent_id'),
        ];

        $oldParentId = null;
        if ($post && $post->parent_id != $attributes['parent_id']) {
            $oldParentId = is_null($post->parent_id) ? 'all' : $post->parent_id;
        }

        // save post to the repository
        $post = $this->repository->store($attributes, $post);

        if (!$post) {
            return;
        }

        $langRepository = $this->getLanguageRepository();
        $code = $request->input('description.lang_code', '');
        $language = $langRepository->findByCode($code);

        if ($language) {
            $this->descriptionRepository->store(
                [
                    'title' => $request->input('description.title', ''),
                    'content' => $request->input('description.content', ''),
                    'page_title' => $request->input('description.page_title', ''),
                    'meta_description' => $request->input('description.meta_description', ''),
                    'meta_keywords' => $request->input('description.meta_keywords', ''),
                ],
                $language,
                $post,
                $post->getDescription($code, false)
            );
        }

        // remove pagination cache
        $this->repository->removePagePaginationCache($post, [$oldParentId]);
        return $post;
    }

    /**
     * redirect to next request
     *
     * @param  App\Models\Post $post
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Post $post = null, Request $request): RedirectResponse
    {
        if (is_null($post)) {
            $this->notifyError(__('Unable to save your request. Please try again sometime'));
        } else {
            $this->notifySuccess(__('Page successfully saved'));
        }

        $langCode = $request->input('description.lang_code');
        return redirect()->route('admin.page.update', ['id' => $post->getKey(), 'lang_code' => $langCode]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        if ($this->request->has('post.id')) {
            $this->middleware('can:pages.update');
        } else {
            $this->middleware('can:pages.create');
        }
    }
}
