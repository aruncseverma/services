<?php

namespace App\Repository;

use App\Models\PostCategory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PostCategoryRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\PostCategory $model
     */
    public function __construct(PostCategory $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage repository
     *
     * @param  array                   $attributes
     * @param  App\Models\PostCategory $model
     *
     * @return App\Models\PostCategory
     */
    public function store(array $attributes, PostCategory $model = null): PostCategory
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

        // create sort clause
        if (!empty($search['sort']) && !empty($search['order'])) {
            $this->createBuilderSort($builder, $search['sort'], $search['order']);
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
    protected function createSearchBuilder(array $search): Builder
    {
        $builder = $this->getBuilder()->with(['descriptions', 'categories']);

        // set clause for the descriptions
        $builder->whereHas('descriptions', function ($query) use ($search) {
            // lang code where clause
            if (!empty($search['lang_code'])) {
                $query->where('lang_code', $search['lang_code']);
            }

            // where name clause
            if (!empty($search['name'])) {
                $query->where('name', 'like', "%{$search['name']}%");
            }

            // where content clause
            if (isset($search['description'])) {
                $query->where('description', 'like', "%{$search['description']}%");
            }
        });

        // is active where clause
        if (isset($search['is_active']) && ($isActive = $search['is_active']) !== '*') {
            $builder->where('is_active', (bool) $isActive);
        }

        // parent where clause
        if (array_key_exists("parent_id", $search)) {
            $builder->where('parent_id', $search['parent_id']);
        }

        // id where clause
        if (!empty($search['id'])) {
            $ids = is_array($search['id']) ? $search['id'] : explode(',', $search['id']);
            $builder->whereIn('id', $ids);
        }

        // slug where clause
        if (isset($search['slug'])) {
            $builder->where('slug', 'like', "%{$search['slug']}%");
        }

        return $builder;
    }

    /**
     * Create unique slug
     * 
     * @param string $name 
     * @param int
     * @return string|bool
     */
    private function generateSlug($name = '', $id = 0)
    {
        if (empty($name)) {
            return false;
        }
        $slug = Str::slug($name, '-');

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
    private function getRelatedSlugs($slug, $id = 0) : Collection
    {
        return $this->getBuilder()
            ->select('slug')
            ->where('slug', 'like', $slug . '%')
            ->where(function ($q) use ($id) {
                if (!empty($id)) {
                    $q->where('id', '<>', $id);
                }
            })
            ->get();
    }

    /**
     * Get post category by slug
     * 
     * @param string $slug
     * 
     * @return App\Models\PostCategory|null
     */
    public function findBySlug($slug = ''): ?PostCategory
    {
        return $this->getBuilder()->where('slug', $slug)->first();
    }

    /**
     * Get post category slug path
     * 
     * @param PostCategory $category
     * @param bool $validate 
     * @return string|bool
     */
    public function getSlugPath($category, $validate = false) : ?string
    {
        $parents = $category->parents;
        // get all parents slugs
        $slugPaths = [];
        if (!is_null($category->parents)) {
            while (!is_null($parents)) {
                if ($validate && !$parents->isActive()) {
                    return false;
                }
                $slugPaths[$parents->id] = $parents->slug;
                $parents = $parents->parent;
            }
            // reverse parent slug paths
            $slugPaths = array_reverse($slugPaths);
        }

        // add current slug
        $slugPaths[$category->getKey()] = $category->slug;
        // build url slug paths
        $slugPath = implode('/', $slugPaths);

        return $slugPath;
    }

    /**
     * Get category url
     * 
     * @param PostCategory $category
     * @return string
     */
    public function getCategoryUrl($category) : string
    {
        $slugPath = $this->getSlugPath($category);
        return route('index.posts.categories.view', ['path' => $slugPath]);
    }

    /**
     * Update parent category
     * 
     * find all categories w/ parent_id equal to $oldParentId
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
     * Get total categories
     * 
     * @return int
     */
    public function getTotalCategories(): int
    {
        return $this->getBuilder()->count();
    }

    /**
     * Get total active categories
     * 
     * @return int
     */
    public function getTotalActiveCategories(): int
    {
        return $this->getBuilder()
            ->where('is_active', true)
            ->count();
    }

    /**
     * Get total inactive categories
     * 
     * @return int
     */
    public function getTotalInactiveCategories(): int
    {
        return $this->getBuilder()
            ->where('is_active', false)
            ->count();
    }
}
