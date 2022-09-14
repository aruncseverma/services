<?php
/**
 * attribute eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Attribute extends Model
{
    /**
     * attributes
     *
     * @const
     */
    const ATTRIBUTE_HAIR_COLOR = 'hair_color';
    const ATTRIBUTE_EYE_COLOR  = 'eye_color';
    const ATTRIBUTE_BODY_TYPE  = 'body_type';
    const ATTRIBUTE_ETHNICITY  = 'ethnicity';
    const ATTRIBUTE_CUP_SIZE   = 'cup_size';
    const ATTRIBUTE_LANGUAGES  = 'languages';

    /**
     * allowed attribute names
     *
     * @const
     */
    const ALLOWED_NAMES = [
        self::ATTRIBUTE_HAIR_COLOR,
        self::ATTRIBUTE_EYE_COLOR,
        self::ATTRIBUTE_BODY_TYPE,
        self::ATTRIBUTE_ETHNICITY,
        self::ATTRIBUTE_CUP_SIZE,
    ];

    /**
     * list of common physical attributes
     *
     * @const
     */
    const COMMON_PHYSICAL_ATTRIBUTES = [
        self::ATTRIBUTE_HAIR_COLOR,
        self::ATTRIBUTE_EYE_COLOR,
        self::ATTRIBUTE_BODY_TYPE,
        self::ATTRIBUTE_ETHNICITY,
        self::ATTRIBUTE_CUP_SIZE,
    ];

    /**
     * cast attribute data types
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool'
    ];

    /**
     * attribute description relation
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions() : Relations\HasMany
    {
        return $this->hasMany(AttributeDescription::class, 'attribute_id');
    }

    /**
     * attribute description relation
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function description() : Relations\HasOne
    {
        return $this->HasOne(AttributeDescription::class, 'attribute_id')->where('lang_code', app()->getLocale());
    }

    /**
     * checks if user is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return (bool) $this->getAttribute('is_active');
    }

    /**
     * get the description based on given code
     *
     * @param  string $code
     *
     * @return App\Models\AttributeDescription
     */
    public function getDescription(string $code) : AttributeDescription
    {
        if ($this->descriptions) {
            foreach ($this->descriptions as $description) {
                if ($description->getAttribute('lang_code') === $code) {
                    return $description;
                }
            }
        }

        // check from database
        $description = $this->descriptions()->where('lang_code', $code)->first();

        return ($description) ?: $this->descriptions()->getModel();
    }
}
