<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Carbon\Carbon;

class PostTag extends Model
{
    use Concerns\HasDescriptions;

    /**
     * cast attributes to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
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
     * relation to post descriptions
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions(): Relations\HasMany
    {
        return $this->hasMany(PostTagDescription::class, 'tag_id');
    }

    /**
     * relation to post category description
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function description(): Relations\HasOne
    {
        return $this->hasOne(PostTagDescription::class, 'tag_id');
    }

    /**
     * Get post builder
     * 
     * @return \Illuminate\Database\Query\Builder|null
     */
    public function getPostBuilder()
    {
        $catId = $this->getKey();
        if (is_null($catId)) {
            return null;
        }
        return \DB::table(app(Post::class)->getTable())
            ->where('post_type', Post::POST_TYPE)
            ->whereRaw("FIND_IN_SET(" . $this->getKey() . ", tag_ids)");
    }

    /**
     * Get tag's total posts
     * 
     * @return int
     */
    public function getTotalPosts(): int
    {
        $postBuilder = $this->getPostBuilder();
        if (!$postBuilder) {
            return 0;
        }
        return $postBuilder->count();
    }

    /**
     * Get total published posts
     * 
     * @return int
     */
    public function getTotalPostsPublished(): int
    {
        $postBuilder = $this->getPostBuilder();
        if (!$postBuilder) {
            return 0;
        }
        return $postBuilder
            ->where('is_active', true)
            ->where('post_at', '<=', Carbon::now())
            ->count();
    }

    /**
     * Get total active posts but not publish yet
     * 
     * @return int
     */
    public function getTotalPostsNotPublishYet(): int
    {
        $postBuilder = $this->getPostBuilder();
        if (!$postBuilder) {
            return 0;
        }
        return $postBuilder
            ->where('is_active', true)
            ->where('post_at', '>', Carbon::now())
            ->count();
    }

    /**
     * Get total pending posts
     * 
     * @return int
     */
    public function getTotalPostsPending(): int
    {
        $postBuilder = $this->getPostBuilder();
        if (!$postBuilder) {
            return 0;
        }
        return $postBuilder
            ->where('is_active', false)
            ->count();
    }
}
