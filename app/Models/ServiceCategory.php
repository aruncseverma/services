<?php
/**
 * eloquent model for service category
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class ServiceCategory extends Model
{
    use Concerns\HasDescriptions;

    /**
     * cast attributes to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
        'ban_locations' => 'array',
    ];

    /**
     * default attributes value
     *
     * @var array
     */
    protected $attributes = [
        'position' => 0
    ];

    /**
     * relation to services model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services() : Relations\HasMany
    {
        $relation = $this->hasMany(Service::class, 'service_category_id');
        $descriptions = $relation->getModel()->descriptions();
        $relationModel = $relation->getModel();
        $relationTable = $relationModel->getTable();
        $relationKey = $relationModel->getKeyName();

        // $relation->join(
        //     $table = $descriptions->getModel()->getTable(),
        //     "{$relationTable}.{$relationKey}",
        //     $descriptions->getQualifiedForeignKeyName()
        // );

        // $relation->where("{$table}.lang_code", "=", app()->getLocale());
        // $relation->orderBy("{$table}.content", 'ASC');
        $relation->orderBy("{$relationTable}.{$relationKey}", 'ASC');

        return $relation;
    }

    /**
     * relation to service category descriptions
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions() : Relations\HasMany
    {
        return $this->hasMany(ServiceCategoryDescription::class, 'service_category_id');
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
     * get ban locations by group
     *
     * @param  string $group
     *
     * @return array
     */
    public function getBanLocationsByGroup(string $group) : array
    {
        // group key maps
        $map = [
            'countries' => 'country_ids',
            'states' => 'state_ids',
            'cities' => 'city_ids',
        ];

        $locations = $this->getAttribute('ban_locations');

        if (! is_array($locations)) {
            return (array) $locations;
        }

        // if group is invalid
        if (! isset($map[$group])) {
            return [];
        }

        // get locations key
        $key = $map[$group];

        if (isset($locations[$key])) {
            return $locations[$key];
        }

        return [];
    }

    /**
     * checks if current escort location is in banned list
     *
     * @param  App\Models\Escort $escort
     *
     * @return boolean
     */
    public function isEscortAllowed(Escort $escort) : bool
    {
        // loop through all locations
        foreach ($escort->locations as $location) {
            // check country
            if (in_array($location->getAttribute('country_id'), $this->getBanLocationsByGroup('countries'))) {
                return false;
            }

            // check states
            if (in_array($location->getAttribute('state_id'), $this->getBanLocationsByGroup('states'))) {
                return false;
            }

            // check cities
            if (in_array($location->getAttribute('city_id'), $this->getBanLocationsByGroup('cities'))) {
                return false;
            }
        }

        return true;
    }
}
