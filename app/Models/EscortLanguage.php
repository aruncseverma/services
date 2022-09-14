<?php
/**
 * user descriptions eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class EscortLanguage extends Model
{
    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = [
        'user',
    ];

    /**
     * this model does not have any timestamps attributes
     *
     * @var boolean
     */
    public $timestamps = false;

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
     * relation to attribute model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute() : Relations\BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id')->with('description');
    }
}
