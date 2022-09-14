<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserActivity extends Model
{
    /**
     * type of escort
     *
     * @const
     */
    const ESCORT_TYPE = 'E';

    /**
     * type of photo
     *
     * @const
     */
    const PHOTO_TYPE = 'P';

    /**
     * type of video
     *
     * @const
     */
    const VIDEO_TYPE = 'V';

    /**
     * type of review
     *
     * @const
     */
    const REVIEW_TYPE = 'R';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(Escort::class, 'user_id');
    }
}
