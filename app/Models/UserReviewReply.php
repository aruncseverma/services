<?php
/**
 * user review replies eloquent model class
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserReviewReply extends Model
{
    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = [
        'review'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['date', 'time'];

    /**
     * relation to review model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * relation to review model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review() : Relations\BelongsTo
    {
        return $this->belongsTo(UserReview::class, 'review_id');
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
     * checks if current reply is seen
     *
     * @return boolean
     */
    public function isSeen(): bool
    {
        return $this->attributes['seen_at'] !== null;
    }
}
