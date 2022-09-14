<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Favorite extends Model
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
     * model eloquent table name
     *
     * @var string
     */
    protected $table = 'favorites';

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
        return $this->belongsTo(Escort::class, 'user_id');
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
     * relation to user description model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function escort(): Relations\HasOne
    {
        return $this->hasOne(Escort::class, 'id', 'object_id');
    }

    /**
     * relation to user description model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function agency(): Relations\HasOne
    {
        return $this->hasOne(Agency::class, 'id', 'object_id');
    }

    /**
     * get the created date
     *
     * @return string
     */
    public function getDateAttribute(): string
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
    public function getTimeAttribute(): string
    {
        if (isset($this->attributes['created_at']) && !empty($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('h:i:s A');
        }
        return '';
    }
}
