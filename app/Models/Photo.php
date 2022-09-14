<?php
/**
 *  Model for escort photos
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Photo extends Model
{
    /**
     *  Photo types
     *
     *  @const
     */
    const PUBLIC_PHOTO = 'M';
    const PRIVATE_PHOTO = 'P';

    /**
     *  The attributes that are mass assignable.
     *
     *  @var array
     */
    protected $fillable = [
        'user_id',  // escort's user id
        'is_primary', // indicates if the photo is set as the escort's primary photo
        'type',   // indicates if the image is public or private
        'folder_id', // indicates if the image is within the public or one of the private photos
        'path', // contains the path to access the photo
    ];

    /**
     * casts values
     *
     * @var array
     */
    protected $casts = [
        'is_primary' => 'bool',
        'data' => 'array'
    ];

    /**
     *  The table associated with the model
     *
     *  @var String
     */
    protected $table = 'photos';

    /**
     *  Indicates if the model should be timestamped.
     *
     *  @var bool
     */
    public $timestamps = true;

    /**
     *  relation to folders
     *
     *  @return Relations\BelongsTo
     */
    public function folder() : Relations\BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id')->withDefault();
    }

    /**
     * relation to users
     *
     * @return Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * check if current photo is primarily defined
     *
     * @return boolean
     */
    public function isPrimary() : bool
    {
        return $this->getAttribute('is_primary');
    }
}
