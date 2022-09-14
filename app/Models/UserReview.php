<?php
/**
 * user reviews eloquent model class
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserReview extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['date', 'time', 'status'];

    /**
     * casts attributes to a value
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'float',
    ];

    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * relation to user review reply model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies() : Relations\HasMany
    {
        return $this->hasMany(UserReviewReply::class, 'review_id')->with('user');
    }

    /**
     * get the created date of review
     *
     * @return string
     */
    public function getDateAttribute() : string
    {
        if (isset($this->attributes['created_at']) && !empty($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('m/d/Y');
        }
        return '';
    }

    /**
     * get the created time of review
     *
     * @return string
     */
    public function getTimeAttribute() : string
    {
        if (isset($this->attributes['created_at']) && !empty($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('h:i:s A');
        }
        return '';
    }

    /**
     * relation to user description model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function object(): Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'object_id');
    }

    /**
     * get the created time of review
     *
     * @return string
     */
    public function getStatusAttribute(): string
    {
        if ($this->attributes['is_approved'] === 1) {
            return 'Approved';
        }

        if ($this->attributes['is_denied'] === 1) {
            return 'Rejected';
        }
        return 'Pending';
    }
}
