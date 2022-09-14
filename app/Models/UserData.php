<?php
/**
 * users_data eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserData extends Model
{
    /**
     * model table name
     */
    protected $table = 'users_data';

    /**
     *  The attributes that are mass assignable.
     *
     *  @var array
     */
    protected $fillable = [
        'user_id',  // escort's user id
        'field', // indicates if the photo is set as the escort's primary photo
        'content',   // indicates if the image is public or private
    ];

    /**
     * this model does not have any timestamps attributes
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = [
        'user',
    ];

    /**
     * relation to User model class
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * content attribute get mutator
     *
     * @return mixed
     */
    public function getContentAttribute()
    {
        if ($this->field == 'contact_platform_ids') {
            return explode(',', $this->attributes['content']);
        }

        return $this->attributes['content'];
    }

    /**
     * content attribute set mutator
     *
     * @param  string $value
     *
     * @return void
     */
    public function setContentAttribute($value)
    {
        // set original value before processing
        //$this->original['content'] =  $value; // eloquent update not saving because of this

        if ($this->field === 'contact_platform_ids') {
            $value = (is_array($value)) ? implode(',', $value) : $value;
        }

        $this->attributes['content'] = $value;
    }
}
