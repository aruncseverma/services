<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Models\Post;
use App\Models\PostPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsLanguages;
use Illuminate\Validation\Rule;
use App\Repository\PostCategoryRepository;
use App\Repository\PostTagRepository;
use App\Support\Concerns\InteractsWithPostPhotoStorage;

class SaveController extends Controller
{
    use NeedsLanguages;
    use InteractsWithPostPhotoStorage;

    const POST_TYPE = Post::POST_TYPE;
    const PHOTO_TYPE = PostPhoto::FEATURED_PHOTO;

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
                $this->notifyError(__('Requested post is invalid'));
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
            //'description.meta_keywords' => 'required',,
            'post.category_ids' => function ($attribute, $value, $fail) {
                if (!empty($value)) {
                    $repository = app(PostCategoryRepository::class);
                    $categories  = $repository->search($limit = 0, ['id' => $value], false);
                    if ($categories->count() != count(explode(',', $value))) {
                        return $fail('Category is invalid.');
                    }
                }
            },
            'post.tag_ids' => function ($attribute, $value, $fail) {
                if (!empty($value)) {
                    $repository = app(PostTagRepository::class);
                    $tags  = $repository->search($limit = 0, ['id' => $value], false);
                    if ($tags->count() != count($value)) {
                        return $fail('Tag is invalid.');
                    }
                }
            },
            'post.allow_comment'   => 'boolean',
            'post.allow_guest_comment'   => 'boolean',
            'post_photo' => [
                'image',
                'dimensions:min_width=150,min_height=200',
            ],
        ];

        $customAttributes = [
            'post.slug' => 'Slug',
            'post.is_active'   => 'Status',
            'post.post_at'   => 'Publish Date',
            'post.allow_comment'   => 'Allow comment',
            'post.allow_guest_comment'   => 'Allow guests to comment',
            'description.title' => 'Title',
            'description.lang_code' => 'Language',
            'description.content' => 'Content',
        ];

        // create unique rule
        ///$uniqueSlug = Rule::unique($this->repository->getTable(), 'slug');
        $langCode = $request->input('description.lang_code', app()->getLocale());
        // $uniqueTitle = Rule::unique($this->descriptionRepository->getTable(), 'title')
        //     ->where(function ($query) use ($langCode) {
        //         return $query->where('lang_code', $langCode);
        //     });

        // append additional rules
        if (!is_null($post)) {
            // appends ignore current model to be updated
            //$uniqueSlug->ignoreModel($post);
            //$uniqueTitle->ignore($post->getKey(), 'post_id');
        }

        $postType = self::DEFAULT_TYPE;
        $postId = $request->input('post.id');
        $uniqueTitle = function ($attribute, $value, $fail) use ($langCode, $postType, $postId) {
            if (!$this->repository->isUniqueTitle($value, $langCode, $postType, $postId)) {
                return $fail('The Title has already been taken.');
            }
        };
        //$rules['post.slug'][] = $uniqueSlug;
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
            'category_ids' => $request->input('post.category_ids'),
            'tag_ids' => $request->input('post.tag_ids'),
            'allow_comment' => $request->input('post.allow_comment', false),
            'allow_guest_comment' => $request->input('post.allow_guest_comment', false),
        ];

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

        // save photo
        $this->savePhoto($post, $request);

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
            $this->notifySuccess(__('Post successfully saved'));
        }

        $langCode = $request->input('description.lang_code');
        return redirect()->route('admin.post.update', ['id' => $post->getKey(), 'lang_code' => $langCode]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        if ($this->request->has('post.id')) {
            $this->middleware('can:posts.update');
        } else {
            $this->middleware('can:posts.create');
        }
    }

    /**
     * upload post's photo
     * 
     * @param Post $post
     * @param Request $request
     * @return bool
     */
    protected function savePhoto(Post $post, Request $request) : bool
    {
        // get previous photo
        $photo = $post->featuredPhoto;

        if ($request->hasFile('post_photo')) {
            // save to storage
            if ($path = $this->uploadPostPhoto($request->file('post_photo'))) {
                // delete previously set
                if (!empty($photo)) {
                    $this->deletePostPhoto($photo->path);
                }

                // store photo information to repository
                $photo = $this->photoRepository->store(
                    [
                        'path' => $path,
                        'type' => self::PHOTO_TYPE,
                        'data' => $request->input('post_photo_data'),
                    ],
                    $post,
                    $photo
                );

                //$this->notifySuccess(__('Featured photo updated successfully'));
                return true;
            }

            // notify warning when saving to disks fails
            $this->notifyWarning(__('Featured photo failed to updated. Please try again sometime'));
            return false;
        } else if ($photo) {
            // store photo information to repository
            $photo = $this->photoRepository->store(
                [
                    'data' => $request->input('post_photo_data'),
                ],
                $post,
                $photo
            );
            return true;
        }

        return false;
    }
}
