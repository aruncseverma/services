<?php
/**
 * eloquent model class for user video folders
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserVideoFolder extends Model
{
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
     * relation to user video model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos() : Relations\HasMany
    {
        return $this->hasMany(UserVideo::class, 'user_video_folder_id')
            ->orderBy('created_at', 'DESC');
    }

    /**
     * get folder name from the path
     *
     * @return string|null
     */
    public function folderName() : ?string
    {
        return basename($this->path);
    }
}
