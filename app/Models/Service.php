<?php
/**
 * service eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Service extends Model
{
    use Concerns\HasDescriptions;

    /**
     * cast attributes to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
    ];

    /**
     * relation to service category model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() : Relations\BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    /**
     * relation to service descriptions model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions() : Relations\HasMany
    {
        return $this->hasMany(ServiceDescription::class, 'service_id');
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
     * relation to service descriptions model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function description() : Relations\HasOne
    {
        return $this->hasOne(ServiceDescription::class, 'service_id')->where('lang_code', app()->getLocale());
    }
}
