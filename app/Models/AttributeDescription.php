<?php
/**
 * attribute descriptions eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class AttributeDescription extends Model
{
    /**
     * this eloquent model does not have any timestamps
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
        'attribute'
    ];

    /**
     * attribute relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute() : Relations\BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
