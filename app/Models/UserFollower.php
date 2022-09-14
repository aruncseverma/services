<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserFollower extends Model
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
    public function follower() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_user_id');
    }

    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function followed() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'followed_user_id');
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
     * customer rating get mutator
     *
     * @return integer
     */
    public function getCustomerRatingAttribute() : int
    {
        if (isset($this->attributes['customer_rating']) && !empty($this->attributes['customer_rating'])) {
            return (int) $this->attributes['customer_rating'];
        }
        return 0;
    }
}
