<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use Concerns\HasDescriptions;

    /**
     * post type value
     */
    const POST_TYPE = 'post';

    /**
     * page type value
     */
    const PAGE_TYPE = 'page';

    /**
     * cache id for page navigation
     */
    const CACHE_ID = 'page_navigations';

    /**
     * cast attributes to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
        'allow_comment' => 'bool',
        'allow_guest_comment' => 'bool',
    ];

    /**
     * tells if this model is active in the database
     *
     * @return boolean
     */
    public function isActive(): bool
    {
        return (bool) $this->getAttribute('is_active');
    }

    /**
     * tells if this model is allow to comment
     *
     * @return boolean
     */
    public function isAllowedComment(): bool
    {
        return (bool) $this->getAttribute('allow_comment');
    }

    /**
     * tells if this model is allow guest to comment
     *
     * @return boolean
     */
    public function isAllowedGuestComment(): bool
    {
        return (bool) $this->getAttribute('allow_guest_comment');
    }

    /**
     * tells if this model is posted in the database
     *
     * @return boolean
     */
    public function isPosted(): bool
    {
        return Carbon::parse($this->attributes['post_at'])->lte(Carbon::now());
    }

    /**
     * Check if this model is post type
     * 
     * @return boolean
     */
    public function isPostType(): bool
    {return $this->getAttribute('post_type') == self::POST_TYPE;
    }

    /**
     * Check if this model is page type
     * 
     * @return boolean
     */
    public function isPageType(): bool
    {
        return $this->getAttribute('post_type') == self::PAGE_TYPE;
    }

    /**
     * relation to post descriptions
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions(): Relations\HasMany
    {
        return $this->hasMany(PostDescription::class, 'post_id');
    }

    /**
     * relation to post description
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function description(): Relations\HasOne
    {
        return $this->hasOne(PostDescription::class, 'post_id');
    }

    /**
     * relations to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * post at attribute set mutator
     *
     * @param  string $value
     *
     * @return void
     */
    public function setPostAtAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['post_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
        }
    }

    /**
     * post at attribute get mutator
     *
     * @return string
     */
    public function getPostAtAttribute(): string
    {
        if (isset($this->attributes['post_at']) && !empty($this->attributes['post_at'])) {
            return Carbon::parse($this->attributes['post_at'])->format('m/d/Y h:i A');
        }
        return '';
    }

    /**
     * relation to post photos model (featured)
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function featuredPhoto(): Relations\HasOne
    {
        return $this->hasOne(PostPhoto::class, 'post_id')
            ->where('type', PostPhoto::FEATURED_PHOTO);
    }

    /**
     * accessor for featured_photo attribute
     *
     * @return App\Models\PostPhoto|null
     */
    public function getFeaturedPhotoAttribute(): ?PostPhoto
    {
        return $this->featuredPhoto()->first();
    }

    /**
     * Retrieves the post's fetaured photo from the uploaded images
     *
     * @return string|null
     */
    public function getFeaturedPhoto(): ?string
    {
        $data = $this->featuredPhoto()->first();

        if ($data) {
            return $data->path;
        }

        return null;
    }

    /**
     * accessor for featured_photo_url attribute
     *
     * @return string|null
     */
    public function getFeaturedPhotoUrlAttribute(): ?string
    {
        $photo = $this->featuredPhoto;

        if (is_null($photo)) {
            return null;
        }

        return route(
            'common.post_photo',
            [
                'path' => $photo->path,
                'photo' => $photo->getKey(),
            ]
        );
    }

    /**
     * tag_ids attribute set mutator
     *
     * @param  array|string $value
     *
     * @return void
     */
    public function setTagIdsAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['tag_ids'] = is_array($value) ? implode(',', $value) : $value;
        } else {
            $this->attributes['tag_ids'] = null;
        }
    }

    /**
     * tag_ids attribute get mutator
     *
     * @return array
     */
    public function getTagIdsAttribute(): array
    {
        if (isset($this->attributes['tag_ids']) && !empty($this->attributes['tag_ids'])) {
            if (is_array($this->attributes['tag_ids'])) {
                return $this->attributes['tag_ids'];
            }
            return explode(',', $this->attributes['tag_ids']);
        }
        return [];
    }

    /**
     * tag_ids_str attribute get mutator
     *
     * @return string
     */
    public function getTagIdsStrAttribute(): string
    {
        return $this->attributes['tag_ids'] ?? '';
    }

    /**
     * relation to post comments
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): Relations\HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    /**
     * Get total comments of the post
     * 
     * @return int
     */
    public function totalComments(): int
    {
        return $this->comments->count();
    }

    /**
     * Get total approved comments of the post
     * 
     * @return int
     */
    public function totalApprovedComments(): int
    {
        return $this->comments->where('is_approved', true)->count();
    }

    /**
     * Get total pending comments of the post
     * 
     * @return int
     */
    public function totalPendingComments(): int
    {
        return $this->comments->where('is_approved', false)->count();
    }

    /**
     * Get total author comments to the post
     * 
     * @return int
     */
    public function totalAuthorComments(): int
    {
        return $this->comments->where('user_id', $this->user_id)->count();
    }

    /**
     * Get previous post
     * 
     * @return Post|null
     */
    public function previous(): ?Post
    {
        return Post::where('post_at', '<', $this->original['post_at'])
            ->where('is_active', true)
            ->where('post_type', $this->post_type)
            ->orderBy('post_at', 'desc')
            ->first();
    }

    /**
     * Get next post
     * 
     * @return Post|null
     */
    public function next(): ?Post
    {
        return Post::where('post_at', '>', $this->original['post_at'])
            ->where('is_active', true)
            ->where('post_type', $this->post_type)
            ->orderBy('post_at', 'asc')
            ->first();
    }

    /**
     * relation to sub pages
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages(): Relations\HasMany
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    /**
     * Recursive pages
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allPages()
    {
        return $this->hasMany(Post::class, 'parent_id')->with('allPages');
    }

    /**
     * Relationship with Parent
     *
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    /**
     * Recursive parents
     *
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parents()
    {
        return $this->belongsTo(Post::class, 'parent_id')->with('parents');
    }

    /**
     * Get post slug path
     * 
     * @param bool $validate 
     * @return string|bool
     */
    public function getSlugPath($validate = false): ?string
    {
        $parents = $this->parents;
        // get all parents slugs
        $slugPaths = [];
        if (!is_null($this->parents)) {
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
        $slugPaths[$this->getKey()] = $this->slug;
        // build url slug paths
        $slugPath = implode('/', $slugPaths);

        return $slugPath;
    }

    /**
     * Get post url
     * 
     * @return string
     */
    public function getPostUrl(): string
    {
        $slugPath = $this->getSlugPath();
        return url($slugPath);
    }
}
