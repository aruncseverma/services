<?php
/**
 * language eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Language extends Model
{
    /**
     * casts attributes
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
    ];

    /**
     * relation to country model
     *
     * @return Relations\BelongsTo
     */
    public function country() : Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    /**
     * checks if model is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return (bool) $this->getAttribute('is_active');
    }

    /**
     * checks if model is defaultly selected
     *
     * @return boolean
     */
    public function isDefault() : bool
    {
        return (bool) $this->getAttribute('is_default');
    }

    /**
     * attribute code set mutator
     *
     * @param  string $code
     *
     * @return void
     */
    public function setCodeAttribute(string $code) : void
    {
        $this->attributes['code'] = strtolower($code);
        $this->original['code'] = $code;
    }
}
