<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Support\Concerns\InteractsWithPostPhotoStorage;
use Illuminate\Support\Facades\Cache;

class PostRepository extends Repository
{
    use InteractsWithPostPhotoStorage;

    /**
     * create instance
     *
     * @param App\Models\Post $model
     */
    public function __construct(Post $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage repository
     *
     * @param  array                   $attributes
     * @param  App\Models\Post $model
     *
     * @return App\Models\Post
     */
    public function store(array $attributes, Post $model = null) : Post
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
            $attributes['slug'] = $this->generateSlug($attributes['slug']);
        } else {
            if (!empty($attributes['slug'])) {
                if ($model->slug != $attributes['slug']) {
                    $attributes['slug'] = $this->generateSlug($attributes['slug'], $model->getKey());
                }
            } else {
                unset($attributes['slug']);
            }
        }

        // map attribute to model
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        // save model to storage
        $model->save();

        return $model;
    }

    /**
     * search repository for given params and return result
     * with a paginated result
     *
     * @param  integer $limit
     * @param  array   $search
     * @param  bool    $isPaginate
     * @param  bool    $isAppend
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator|Illuminate\Database\Eloquent\Collection;
     */
    public function search(int $limit, array $search = [], $isPaginate = true, $isAppend = true)
    {
        $builder = $this->createSearchBuilder($search);

        // define all allowed fields to be sorted
        $allowedOrderFields = [
            'id',
            Post::CREATED_AT,
            Post::UPDATED_AT,
        ];

        // create sort clause
        $search['sort_order'] = $search['sort_order'] ?? 'asc';
        if (!empty($search['sort']) && !empty($search['sort_order'])) {
            $this->createBuilderSort($builder, $search['sort'], $search['sort_order'], $allowedOrderFields);
        }
        
        if ($isPaginate) {
            $pagination = $builder->paginate($limit);
            if ($isAppend) {
                $pagination->appends($search);
            }
            return $pagination;
        }

        if ($limit > 0) {
            $builder->take($limit);
        }
        
        return $builder->get();
    }

    /**
     * create builder instance
     *
     * @param  array $search
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $search) : Builder
    {
        $withs = ['descriptions'];
        if (!empty($search['with_pages'])) {
            $withs[] = 'pages';
        }
        $builder = $this->getBuilder()->with($withs);

        // set clause for the descriptions
        if (!empty($search['title'])
            || !empty($search['content'])
            || !empty($search['s'])
        ) {
            $builder->whereHas('descriptions', function ($query) use ($search) {
                // lang code where clause
                if (!empty($search['lang_code'])) {
                    $query->where('lang_code', $search['lang_code']);
                }

                // where title clause
                if (!empty($search['title'])) {
                    $query->where('title', 'like', "%{$search['title']}%");
                }

                // where content clause
                if (isset($search['content'])) {
                    $query->where('content', 'like', "%{$search['content']}%");
                }

                if (!empty($search['s'])) {
                    $searchText = $search['s'];
                    $query->where(function($q) use ($searchText) {
                        $q->orWhere('title', 'like', "%{$searchText}%");
                        $q->orWhere('content', 'like', "%{$searchText}%");
                    });
                }
            });
        }

        // post id where clause
        if (!empty($search['id'])) {
            $ids = is_array($search['id']) ? $search['id'] : explode(',', $search['id']);
            $builder->whereIn('id', $ids);
        }
        // is active where clause
        if (isset($search['is_active']) && ($isActive = $search['is_active']) !== '*') {
            $builder->where('is_active', (bool) $isActive);
        }

        // where post type clause
        if (!empty($search['post_type'])) {
            $builder->where('post_type', $search['post_type']);
        }

        // where category ids clause
        if (!empty($search['category_id'])) {
            $categoryIds = is_array($search['category_id']) ? $search['category_id'] : explode(',', $search['category_id']);
            foreach($categoryIds as $catId) {
                $builder->whereRaw('FIND_IN_SET(?,category_ids)', [$catId]);
            }
        }

        // where tag ids clause
        if (!empty($search['tag_id'])) {
            $tagIds = is_array($search['tag_id']) ? $search['tag_id'] : explode(',', $search['tag_id']);
            foreach ($tagIds as $tagId) {
                $builder->whereRaw('FIND_IN_SET(?,tag_ids)', [$tagId]);
            }
        }

        // parent where clause
        if (array_key_exists("parent_id", $search)) {
            $builder->where('parent_id', $search['parent_id']);
        }

        // all published or all not published yet
        if (array_key_exists("published", $search)) {
            $builder->where('is_active', true);
            if ($search['published'] == 1) {
                $builder->where('post_at', '<=', Carbon::now());
            } elseif ($search['published'] == 0) {
                $builder->where('post_at', '>', Carbon::now());
            }
        } else {
            if (!empty($search['pending'])) {
                $builder->where('is_active', false);
            }
        }

        // slug where clause
        if (isset($search['slug'])) {
            $builder->where('slug', 'like', "%{$search['slug']}%");
        }

        // post_at
        if (!empty($search['post_at_start'])) {
           $builder->whereDate('post_at', '>=', date("Y-m-d", strtotime($search['post_at_start'])));
        }
        if (!empty($search['post_at_end'])) {
            $builder->whereDate('post_at', '<=', date("Y-m-d", strtotime($search['post_at_end'])));
        }

        if (!empty($search['author'])) {
            $builder->whereHas('author', function ($query) use ($search) {
                // author where clause
                if (!empty($search['author'])) {
                    $query->where('name', 'like', "%{$search['author']}%");
                }
            });
        }
        return $builder;
    }

    /**
     * Create unique slug
     * 
     * @param string $title 
     * @param int
     * @return string|bool
     */
    private function generateSlug($title = '', $id = 0)
    {
        if (empty($title)) {
            return false;
        }
        $slug = Str::slug($title, '-');

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        $count = 1;
        $newSlug = $slug . '-' . $count;
        while ($allSlugs->contains('slug', $newSlug)) {
            ++$count;
            $newSlug = $slug . '-' . $count;
        }
        return $newSlug;
    }

    /**
     * Get Related slugs
     * 
     * @param string $slug
     * @param int $id
     * @return Collection
     */
    private function getRelatedSlugs($slug, $id = 0)
    {
        return $this->getBuilder()
            ->select('slug')
            ->where('slug', 'like', $slug . '%')
            ->where(function($q) use ($id) {
                if (!empty($id)) {
                    $q->where('id', '<>', $id);
                }
            })
            ->get();
    }

    /**
     * Get post by slug
     * 
     * @param string $slug
     * 
     * @return App\Models\Post|null
     */
    public function findBySlug($slug = '') :?Post
    {
        return $this->getBuilder()->where('slug', $slug)->first();
    }

    /**
     * Get category names by category_ids path
     * 
     * @param LengthAwarePaginator|Collection $posts
     * @param string $langCode
     * @return array
     */
    public function getCategoryIdsNames($posts, $langCode): array
    {
        $catNames = [];
        $categoryIds = [];

        if (!$posts) {
            return $catNames;
        }

        // get all category ids and category path w/ value of category ids
        foreach ($posts as $post) {
            if (empty($post->category_ids)) {
                continue;
            }
            $catIds = explode(',', $post->category_ids);
            foreach ($catIds as $id) {
                $categoryIds[$id] = $id;
            }
            $catNames[$post->category_ids] = $catIds;
        }

        // get categories by category ids
        if (!empty($categoryIds)) {
            $categoryIds = $this->getCategoryNamesByCategoryIds($categoryIds, $langCode);

            // replace category_id to category name
            foreach ($catNames as $k => $ids) {
                $newVals = [];
                foreach ($ids as $id) {
                    $newVals[$id] = $categoryIds[$id];
                }

                $catNames[$k] = $newVals;
            }
        }

        return $catNames;
    }

    /**
     * get category names by category ids
     * 
     * @param array|string $categoryIds
     * @param string $langCode
     * @param array $conditions
     * 
     * @return array
     */
    public function getCategoryNamesByCategoryIds($categoryIds, $langCode, array $conditions = []) : array
    {
        if (!empty($categoryIds)) {
            if (!is_array($categoryIds)) {
                $categoryIds = explode(',', $categoryIds);
            }
            $categoryIds = array_combine($categoryIds, $categoryIds); // use values as array key

            $repository = app(\App\Repository\PostCategoryRepository::class);
            $categories  = $repository->search($limit = 0, 
                array_merge(['id' => $categoryIds], $conditions), 
                false
            );
            
            $catIdNames = [];
            foreach ($categories as $category) {
                $catIdNames[$category->getKey()] = $category->getDescription($langCode, true)->name;
            }

            foreach ($categoryIds as $catId => $val) {
                if (isset($catIdNames[$catId])) {
                    $categoryIds[$catId] = $catIdNames[$catId];
                } else {
                    unset($categoryIds[$catId]);
                }
            }
        }

        return $categoryIds ?? [];
    }

    /**
     * Remove category id to all posts that associated to this category
     * 
     * @param int $categoryId
     * @return int Affected Rows
     */
    public function removeCategoryId($categoryId) : int
    {
        $affectedRows = 0;
        $replace = '';

        // Finds any values that equal to "id"
        $find = $categoryId;
        $replaceString = sprintf('REPLACE(category_ids,"%s","%s")', $find, $replace);
        $affectedRows += $this->getModel()
            ->where('category_ids', $find)
            ->update([
                'category_ids' => \DB::raw($replaceString),
            ]);

        // Finds any values that start with "id,"
        $find = $categoryId . ',';
        $replaceString = sprintf('REPLACE(category_ids,"%s","%s")', $find, $replace);
        $affectedRows += $this->getModel()
            ->where('category_ids', 'like', $find . '%')
            ->update([
                'category_ids' => \DB::raw($replaceString),
            ]);

        // Finds any values that end with ",id"
        $find = ',' . $categoryId;
        $replaceString = sprintf('REPLACE(category_ids,"%s","%s")', $find, $replace);
        $affectedRows += $this->getModel()
            ->where('category_ids', 'like', '%' . $find)
            ->update([
                'category_ids' => \DB::raw($replaceString),
            ]);

        // Finds any values that have ",id," in any position
        $replace = ',';
        $find = ',' . $categoryId . ',';
        $replaceString = sprintf('REPLACE(category_ids,"%s","%s")', $find, $replace);
        $affectedRows += $this->getModel()
            ->where('category_ids', 'like', '%' . $find . '%')
            ->update([
                'category_ids' => \DB::raw($replaceString),
            ]);

        return $affectedRows;
    }

    /**
     * Get tag names by tags_ids path
     * 
     * @param LengthAwarePaginator|Collection $posts
     * @param string $langCode
     * @return array
     */
    public function getTagIdsNames($posts, $langCode): array
    {
        $tagNames = [];
        $tagIds = [];

        if (!$posts) {
            return $tagNames;
        }

        // get all category ids and category path w/ value of category ids
        foreach ($posts as $post) {
            if (empty($post->tag_ids)) {
                continue;
            }
            $ids = $post->tag_ids;
            if (!is_array($ids)) {
                $ids = explode(',', $ids);
            }
            foreach ($ids as $id) {
                $tagIds[$id] = $id;
            }
            $tagNames[$post->tag_ids_str] = $ids;
        }

        // get tags by tag ids
        if (!empty($tagIds)) {
            $tagIds = $this->getTagNamesByTagIds($tagIds, $langCode);

            // replace tag_id to tag name
            foreach ($tagNames as $k => $ids) {
                $newVals = [];
                foreach ($ids as $id) {
                    $newVals[$id] = $tagIds[$id];
                }

                $tagNames[$k] = $newVals;
            }
        }

        return $tagNames;
    }

    /**
     * get tag names by tag ids
     * 
     * @param array|string $tagIds
     * @param string $langCode
     * 
     * @return array
     */
    public function getTagNamesByTagIds($tagIds, $langCode): array
    {
        if (!empty($tagIds)) {
            if (!is_array($tagIds)) {
                $tagIds = explode(',', $tagIds);
            }
            $tagIds = array_combine($tagIds, $tagIds); // use values as array key

            $repository = app(\App\Repository\PostTagRepository::class);
            $tags  = $repository->search($limit = 0, ['id' => $tagIds], false);
            foreach ($tags as $tag) {
                if (isset($tagIds[$tag->getKey()])) {
                    $tagIds[$tag->getKey()] = $tag->getDescription($langCode, true)->name;
                }
            }
        }
        return $tagIds;
    }

    /**
     * get tags by tag ids
     * 
     * @param array|string $tagIds
     * @param array $conditions
     * 
     * @return Collection|null
     */
    public function getTagsByTagIds($tagIds, array $conditions = []): ? Collection
    {
        if (empty($tagIds)) {
            return null;
        }
        if (!is_array($tagIds)) {
            $tagIds = explode(',', $tagIds);
        }

        $repository = app(\App\Repository\PostTagRepository::class);
        $tags  = $repository->search($limit = 0, 
            array_merge(['id' => $tagIds], $conditions)
        , false);
        return $tags;
    }

    /**
     * Remove tag id to all posts that associated to this tag
     * 
     * @param int $tagId
     * @return int Affected Rows
     */
    public function removeTagId($tagId): int
    {
        $affectedRows = 0;
        $replace = '';

        // Finds any values that equal to "id"
        $find = $tagId;
        $replaceString = sprintf('REPLACE(tag_ids,"%s","%s")', $find, $replace);
        $affectedRows += $this->getModel()
            ->where('tag_ids', $find)
            ->update([
                'tag_ids' => \DB::raw($replaceString),
            ]);

        // Finds any values that start with "id,"
        $find = $tagId . ',';
        $replaceString = sprintf('REPLACE(tag_ids,"%s","%s")', $find, $replace);
        $affectedRows += $this->getModel()
            ->where('tag_ids', 'like', $find . '%')
            ->update([
                'tag_ids' => \DB::raw($replaceString),
            ]);

        // Finds any values that end with ",id"
        $find = ',' . $tagId;
        $replaceString = sprintf('REPLACE(tag_ids,"%s","%s")', $find, $replace);
        $affectedRows += $this->getModel()
            ->where('tag_ids', 'like', '%' . $find)
            ->update([
                'tag_ids' => \DB::raw($replaceString),
            ]);

        // Finds any values that have ",id," in any position
        $replace = ',';
        $find = ',' . $tagId . ',';
        $replaceString = sprintf('REPLACE(tag_ids,"%s","%s")', $find, $replace);
        $affectedRows += $this->getModel()
            ->where('tag_ids', 'like', '%' . $find . '%')
            ->update([
                'tag_ids' => \DB::raw($replaceString),
            ]);

        return $affectedRows;
    }

    /**
     * Check if title is unique
     * 
     * @param string $title
     * @param string|null $langCode
     * @param string|null $postType
     * @param int|null $postId
     * @return bool
     */
    public function isUniqueTitle($title, $langCode = null, $postType = null, $postId = null) : bool
    {
        if (is_null($langCode)) {
            $langCode = app()->getLocale();
        }
        if (is_null($postType)) {
            $postType = POST::POST_TYPE;
        }

        $rows = $this->getBuilder()
            ->join('post_descriptions', 'posts.id', 'post_descriptions.post_id')
            ->where('posts.post_type', $postType)
            ->where('post_descriptions.lang_code', $langCode)
            ->where('post_descriptions.title', $title)
            ->where(function($q) use ($postId) {
                if (!empty($postId)) {
                    $q->where('post_descriptions.post_id', '!=', $postId);
                }
            })
            ->first();
        return (!$rows);
    }

    /**
     * Get latest post
     * 
     * @param int $limit
     * @return Collection
     */
    public function getLatest($limit = 5) : Collection
    {
        $rows = $this->getBuilder()->where('post_type', Post::POST_TYPE)->where('is_active', true)->latest()->take($limit)->get();
        return $rows;
    }

    /**
     * Get category ids that are in use
     * 
     * @return array
     */
    public function getCategoryIdsUsed(string $postType = null) : array
    {
        $postType = $postType ?? POST::POST_TYPE;
        $row = $this->getBuilder()
            ->select(\DB::raw('group_concat(category_ids SEPARATOR ",") AS all_category_ids'))
            ->where('is_active', true)
            ->where('post_type', $postType)
            ->whereDate('post_at', '<', \Carbon\Carbon::now())
            ->where(function($q){
                $q->orWhere('category_ids', null);
                $q->orWhere('category_ids', '!=', '');
            })
            ->first();
        $ids = [];
        // has row and all_category_ids is not null
        if ($row && $row->all_category_ids) {
            $ids = array_unique(explode(',', $row->all_category_ids));
        }
        return $ids;
    }

    /**
     * Get total posts by post type
     * 
     * @param string $postType default 'post'
     * @return int
     */
    public function getTotalPosts($postType = null) : int
    {
        $postType = $postType ?? Post::POST_TYPE;
        return $this->getBuilder()
        ->where('post_type', $postType)
        ->count();
    }

    /**
     * Get total published posts by post type
     * 
     * @param string $postType default 'post'
     * @return int
     */
    public function getTotalPublished($postType = null) : int
    {
        $postType = $postType ?? Post::POST_TYPE;
        return $this->getBuilder()
        ->where('post_type', $postType)
        ->where('is_active', true)
        ->where('post_at', '<=', Carbon::now())
        ->count();
    }

    /**
     * Get total active posts but not publish yet by post type
     * 
     * @param string $postType default 'post'
     * @return int
     */
    public function getTotalNotPublishYet($postType = null): int
    {
        $postType = $postType ?? Post::POST_TYPE;
        return $this->getBuilder()
            ->where('post_type', $postType)
            ->where('is_active', true)
            ->where('post_at', '>', Carbon::now())
            ->count();
    }

    /**
     * Get total pending posts by post type
     * 
     * @param string $postType default 'post'
     * @return int
     */
    public function getTotalPending($postType = null): int
    {
        $postType = $postType ?? Post::POST_TYPE;
        return $this->getBuilder()
            ->where('post_type', $postType)
            ->where('is_active', false)
            ->count();
    }

    /**
     * Update parent page
     * 
     * find all pages w/ parent_id equal to $oldParentId
     * and replace it with the value of $newParentId
     * 
     * @param int|null $oldParentId 
     * @param int|null $newParentId 
     * @return int
     */
    public function updateParentId($oldParentId = null, $newParentId = null) : int
    {
        return $this->getModel()
            ->where('parent_id', $oldParentId)
            ->update([
                'parent_id' => $newParentId,
            ]);
    }

    /**
     * Clone post data
     * 
     * @param Post $originalPost
     * @return Post
     */
    public function cloneData($originalPost)
    {
        // copy attributes from original model
        $clonePost = $originalPost->replicate();
        // override attributes
        $clonePost->slug = $this->generateSlug($clonePost->slug . '-clone');
        $clonePost->is_active = false;
        // save clone
        $clonePost->save();

        // clone descriptions
        $descRepo = app(PostDescriptionRepository::class);
        $descriptions = $originalPost->descriptions;
        if ($descriptions) {
            foreach ($descriptions as $desc) {
                $cloneDesc = $desc->replicate();
                // change post id and title
                $cloneDesc->post_id = $clonePost->id;
                $cloneDesc->title = $descRepo->generateTitle($cloneDesc->title . ' [CLONE]', $cloneDesc->lang_code);
                $cloneDesc->save();
            }
        }

        // clone featured image
        $featuredPhoto = $originalPost->featuredPhoto;
        if ($featuredPhoto) {
            $contents = $this->getPostPhotoStorage()->get($featuredPhoto->path);
            $newFeautredImagePath = 'clone-' . $featuredPhoto->path;
            $isCopy = $this->getPostPhotoStorage()->put($newFeautredImagePath, $contents);
            if ($isCopy) {
                $cloneFeaturedImage = $featuredPhoto->replicate();
                $cloneFeaturedImage->post_id = $clonePost->id;
                $cloneFeaturedImage->path = $newFeautredImagePath;
                $cloneFeaturedImage->save();
            }
        }

        return $clonePost;
    }

    /**
     * Multiple clone post data
     * 
     * @param array $pageIds
     * @return Collection
     */
    public function multipleCloneData($pageIds = [])
    {
        $clonePosts = collect();
        if (!empty($pageIds)) {
            foreach($pageIds as $pageId) {
                $originalPost = $this->find($pageId);
                if ($originalPost) {
                    $clonePost = $this->cloneData($originalPost);
                    if ($clonePost) {
                        $clonePosts->put($clonePost->getKey(), $clonePost);
                    }
                }
            }
        }
        return $clonePosts;
    }

    /**
     * Remove page pagination cache
     * 
     * @param Post $page
     * @param array $pageIds
     * @return void
     */
    public function removePagePaginationCache($page = null, $pageIds = [])
    {
        $cacheId = Post::CACHE_ID;
        if (Cache::has($cacheId)) {
            $values = Cache::get($cacheId);

            $cacheKeys = [];
            if ($page) {
                $cacheKeys[] = $page->getKey();
                if (!empty($page->parent_id)) {
                    $cacheKeys[] = $page->parent_id;
                } else {
                    $cacheKeys[] = 'all';
                }
            } else {
                $cacheKeys[] = 'all';
            }

            if (!empty($pageIds)) {
                $cacheKeys = array_merge($cacheKeys, $pageIds);
            }
            if (!empty($cacheKeys)) {
                foreach ($cacheKeys as $key) {
                    if (isset($values[$key])) {
                        unset($values[$key]);
                    }
                }
            }

            Cache::forever($cacheId, $values);
        }
    }
}
