<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class EscortReview extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['date', 'time'];

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
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }

    /**
     * relation to escort language model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies() : Relations\HasMany
    {
        return $this->hasMany(EscortReviewReply::class, 'review_id')->with('user');
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
}
