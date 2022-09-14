<?php
/**
 * eloquent class model for rate durations table
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class RateDuration extends Model
{
    use Concerns\HasDescriptions;

    /**
     * this model does not have any timestamps fields
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * cast attributes to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
    ];

    /**
     * relation to rate duration descriptions
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions() : Relations\HasMany
    {
        return $this->hasMany(RateDurationDescription::class, 'rate_duration_id');
    }

    /**
     * tells if this model is active in the database
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return (bool) $this->getAttribute('is_active');
    }

    /**
     * relation to escort rate
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function escortRates() : Relations\HasMany
    {
        return $this->hasMany(EscortRate::class, 'rate_duration_id');
    }

    /**
     * relation to escort rate
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function escortRate() : Relations\HasOne
    {
        return $this->hasOne(EscortRate::class, 'rate_duration_id');
    }

    /**
     * relation to rate duration description
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function description() : Relations\HasOne
    {
        return $this->hasOne(RateDurationDescription::class, 'rate_duration_id');
    }
}
