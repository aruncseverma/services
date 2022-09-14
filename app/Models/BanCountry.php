<?php
/**
 * user ban countries eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class BanCountry extends Model
{
    /**
     * model does not have any timestamps as attributes
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
     * relation to country model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country() : Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * relation to user model class
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
