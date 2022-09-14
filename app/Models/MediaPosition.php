<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaPosition extends Model
{
    protected $fillable = [
        'media_id',
        'folder_id',
        'user_id'
    ];

    public $timestamps = true;

    /**
     * video details
     *
     * @return $video Relation\BelongsTo
     */
    public function video() : BelongsTo
    {
        return $this->belongsTo(UserVideo::class, 'media_id');
    }

    public function photo() : BelongsTo
    {
        return $this->belongsTo(Photo::class, 'media_id');
    }

    /**
     * escort information
     *
     * @return $user Relation\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}