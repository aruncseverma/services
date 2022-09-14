<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Comment extends Model
{
    /**
     * type of escort
     *
     * @const
     */
    const ESCORT_TYPE = 'E';

    /**
     * type of agency
     *
     * @const
     */
    const AGENCY_TYPE = 'G';

    /**
     * cast attributes to specified data type
     *
     * @var array
     */
    protected $casts = [
        'is_hearted' => 'bool',
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

    /**
     * relation to user description model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function escort(): Relations\HasOne
    {
        return $this->hasOne(Escort::class, 'id', 'object_id')->where('type', Escort::USER_TYPE);
    }

    /**
     * get the created date
     *
     * @return string
     */
    public function getCreatedDateAttribute(): string
    {
        if (isset($this->attributes['created_at']) && !empty($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('m/d/Y');
        }
        return '';
    }

    /**
     * get the created time
     *
     * @return string
     */
    public function getCreatedTimeAttribute(): string
    {
        if (isset($this->attributes['created_at']) && !empty($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('h:i:s A');
        }
        return '';
    }

    /**
     * checks if comment is hearted
     *
     * @return boolean
     */
    public function isHearted(): bool
    {
        return $this->getAttribute('is_hearted');
    }
}
