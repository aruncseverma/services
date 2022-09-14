<?php
/**
 * continents eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Continent extends Model
{
    /**
     * model does not have any timestamps as attributes
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * countries relation
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countries() : Relations\HasMany
    {
        return $this->hasMany(Countries::class, 'continent_id');
    }

    /**
     * relation to states model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function states() : Relations\HasManyThrough
    {
        return $this->hasManyThrough(State::class, Country::class);
    }
}
