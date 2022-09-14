<?php
/**
 * city eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class City extends Model
{
    /**
     * model does not have any timestamps as attributes
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * cast attributes
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool'
    ];

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
     * get continent mutator
     *
     * @return App\Models\Continent
     */
    public function getContinentAttribute()
    {
        return $this->state->country->continent;
    }

    /**
     * get continent mutator
     *
     * @return App\Models\Continent
     */
    public function getCountryAttribute()
    {
        return $this->state->country;
    }

    /**
     * checks if user is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return $this->getAttribute('is_active');
    }
}
