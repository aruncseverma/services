<?php
/**
 * packages eloquent model class
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Package extends Model
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
     * relation to biller model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function biller() : Relations\BelongsTo
    {
        return $this->belongsTo(Biller::class, 'biller_id');
    }

    /**
     * relation to currency model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency() : Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * checks if biller is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return $this->getAttribute('is_active');
    }
}
