<?php
/**
 * eloquent model class for escort services
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class EscortService extends Model
{
    /**
     * types of service
     *
     * @const
     */
    const TYPE_STANDARD = 'S';
    const TYPE_EXTRA = 'E';
    const TYPE_NOT = 'N';

    /**
     * allowed types
     *
     * @const
     */
    const ALLOWED_TYPES = [
        self::TYPE_STANDARD,
        self::TYPE_EXTRA,
        self::TYPE_NOT,
    ];

    /**
     * this model does not have any timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * relations that will be updated when this model is updated
     *
     * @var array
     */
    protected $touches = [
        'escort'
    ];

    /**
     * relation to escort model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function escort() : Relations\BelongsTo
    {
        return $this->belongsTo(Escort::class, 'user_id');
    }

    /**
     * relation to service model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service() : Relations\BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
