<?php
/**
 * escort rates eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class EscortRate extends Model
{
    /**
     * cast attributes to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'incall' => 'double',
        'outcall' => 'double',
    ];

    /**
     * attributes default values
     *
     * @var array
     */
    protected $attributes = [
        'incall' => 0.00,
        'outcall' => 0.00,
    ];

    /**
     * relations to rate duration model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function duration() : Relations\BelongsTo
    {
        return $this->belongsTo(RateDuration::class, 'rate_duration_id');
    }

    /**
     * relations to escort model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function escort() : Relations\BelongsTo
    {
        return $this->belongsTo(Escort::class, 'user_id');
    }

    /**
     * relations to currency model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency() : Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
