<?php
/**
 * eloquent model class for user videos
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserVideo extends Model
{
    /**
     * video visibilities
     *
     * @const
     */
    const VISIBILITY_PUBLIC = 'P';
    const VISIBILITY_PRIVATE = 'V';

    /**
     * relations to user video folder model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder() : Relations\BelongsTo
    {
        return $this->belongsTo(UserVideoFolder::class, 'user_video_folder_id');
    }

    /**
     * relations to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * check if current video is private
     *
     * @return boolean
     */
    public function isPrivate() : bool
    {
        return ($this->getAttribute('visibility') == static::VISIBILITY_PRIVATE);
    }

    /**
     * check if current video is public
     *
     * @return boolean
     */
    public function isPublic() : bool
    {
        return ($this->getAttribute('visibility') == static::VISIBILITY_PUBLIC);
    }
}
