<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class PostPhoto extends Model
{
    /**
     *  Photo types
     *
     *  @const
     */
    const FEATURED_PHOTO = 'F';
    const ADDITIONAL_PHOTO = 'A';

    /**
     * attributes to be casted to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];

    /**
     * relation to post
     *
     * @return Relations\BelongsTo
     */
    public function post() : Relations\BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * check if photo is featured photo
     *
     * @return boolean
     */
    public function isFeaturedPhoto() : bool
    {
        return ($this->getAttribute('type') == self::FEATURED_PHOTO);
    }
}
