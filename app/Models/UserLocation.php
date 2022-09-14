<?php
/**
 * user address profiles eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserLocation extends Model
{
    /**
     * type of main location
     *
     * @const
     */
    const MAIN_LOCATION_TYPE = 'M';

    /**
     * type of additional location
     *
     * @const
     */
    const ADDITIONAL_LOCATION_TYPE = 'A';

    /**
     * maximum number of additional location
     *
     * @const
     */
    const MAXIMUM_ADDITIONAL_LOCATION = 5;

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
        return $this->belongsTo(Continent::class, 'continent_id')
            ->withDefault();
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
}
