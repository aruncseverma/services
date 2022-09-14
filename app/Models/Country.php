<?php
/**
 * country eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Country extends Model
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
     * relation to continent model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function continent() : Relations\BelongsTo
    {
        return $this->belongsTo(Continent::class, 'continent_id');
    }

    /**
     * relation to state model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states() : Relations\HasMany
    {
        return $this->hasMany(State::class, 'country_id');
    }

    /**
     * relation to cities model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function cities() : Relations\HasManyThrough
    {
        return $this->hasManyThrough(City::class, State::class);
    }

    /**
     * relation to langauges model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function languages() : Relations\HasMany
    {
        return $this->hasMany(Language::class, 'country_id');
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
