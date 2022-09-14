<?php
/**
 * service description eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class ServiceDescription extends Model
{
    /**
     * this model does not have any timestamps defined
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * relationships that will be updated when this model is updated
     *
     * @var array
     */
    protected $touches = [
        'service',
    ];

    /**
     * relation to service model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service() : Relations\BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * relation to language model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language() : Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'lang_code', 'code');
    }
}
