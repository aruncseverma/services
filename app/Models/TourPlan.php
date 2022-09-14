<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class TourPlan extends Model
{
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
     * relation to continent model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function continent() : Relations\BelongsTo
    {
        return $this->belongsTo(Continent::class, 'continent_id');
    }

    /**
     * relation to country model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country() : Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * relation to state model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state() : Relations\BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * relation to city model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city() : Relations\BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * date start attribute set mutator
     *
     * @param  string $dateStart
     *
     * @return void
     */
    public function setDateStartAttribute($dateStart)
    {
        if (!empty($dateStart)) {
            $this->attributes['date_start'] = Carbon::parse($dateStart)->format('Y-m-d');
        }
    }

    /**
     * date start attribute get mutator
     *
     * @return string
     */
    public function getDateStartAttribute() : string
    {
        if (isset($this->attributes['date_start']) && !empty($this->attributes['date_start'])) {
            return Carbon::parse($this->attributes['date_start'])->format('m/d/Y');
        }
        return '';
    }

    /**
     * date end attribute set mutator
     *
     * @param  string $dateEnd
     *
     * @return void
     */
    public function setDateEndAttribute($dateEnd)
    {
        if (!empty($dateEnd)) {
            $this->attributes['date_end'] = Carbon::parse($dateEnd)->format('Y-m-d');
        }
    }

    /**
     * date end attribute get mutator
     *
     * @return string
     */
    public function getDateEndAttribute() : string
    {
        if (isset($this->attributes['date_end']) && !empty($this->attributes['date_end'])) {
            return Carbon::parse($this->attributes['date_end'])->format('m/d/Y');
        }
        return '';
    }
}
