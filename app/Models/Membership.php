<?php
/**
 * model for membership plans
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    protected $table = "membership";

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
     * relation to currency model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency() : BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * checks if membership plan is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return $this->getAtrribute('is_active');
    }
}
