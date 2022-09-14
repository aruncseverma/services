<?php
/**
 * states eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class State extends Model
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
     * relation to country model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country() : Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * relation to city model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities() : Relations\HasMany
    {
        return $this->hasMany(City::class, 'state_id');
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
