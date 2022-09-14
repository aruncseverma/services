<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostComment extends Model
{
    /**
     * cast attributes to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'is_approved' => 'bool',
    ];

    /**
     * tells if this model is approve in the database
     *
     * @return boolean
     */
    public function isApproved(): bool
    {
        return (bool) $this->getAttribute('is_approved');
    }

    /**
     * relation to sub comments
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): Relations\HasMany
    {
        return $this->hasMany(PostComment::class, 'parent_id');
    }

    /**
     * Recursive comments
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allComments()
    {
        return $this->hasMany(PostComment::class, 'parent_id')->with('allComments');
    }

    /**
     * Relationship with Parent
     *
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    /**
     * Recursive parents
     *
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parents()
    {
        return $this->belongsTo(PostComment::class, 'parent_id')->with('parents');
    }

    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * relation to post model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): Relations\BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
