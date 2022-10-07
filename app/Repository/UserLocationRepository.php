<?php
/**
 * user locations repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Agency;
use App\Models\User;
use App\Models\UserData;
use App\Models\UserLocation;
use Illuminate\Support\Facades\DB;

class UserLocationRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserLocation $model
     */
    public function __construct(UserLocation $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\User         $user
     * @param  App\Models\UserLocation $model
     *
     * @return App\Models\UserLocation
     */
    public function store(array $attributes, User $user, UserLocation $model = null) : UserLocation
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        $model->user()->associate($user);

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }

    /**
     * find user description by lang_code that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\UserData|null
     */
    public function findUserLocationById(string $id, User $user) : ?UserData
    {
        return $user->locations()->where('id', $id)->first();
    }

    /**
     * Get All available locations with escorts
     *
     * @param string $param
     * @return void
     */
    public function getEscortLocations(string $param, string $key, array $otherConditions = [])
    {
        $model = $this->getModel()->newModelInstance()
            ->with('continent')
            ->with('country')
            ->with('state')
            ->with('city');

        $mainTable = $model->getModel()->getTable();
        $mainTableKey = $model->getModel()->getKeyName();

        if ($param == 'state') {
            $relation = $model->getModel()->state();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$relation->getForeignKeyName()}", "=", "{$foreignTable}.{$mainTableKey}");

            $model->select('state_id', DB::raw('count(*) as total'));
            $model->where("{$mainTable}.country_id", $key);
            $model->groupBy('state_id');

        } else if ($param == 'city') {
            $relation = $model->getModel()->city();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$relation->getForeignKeyName()}", "=", "{$foreignTable}.{$mainTableKey}");

            $model->select('city_id', DB::raw('count(*) as total'));
            $model->where("{$mainTable}.state_id", $key);
            $model->groupBy('city_id');
        } else if ($param == 'country') {
            $relation = $model->getModel()->country();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$relation->getForeignKeyName()}", "=", "{$foreignTable}.{$mainTableKey}");

            $model->select('country_id', DB::raw('count(*) as total'));
            $model->where("{$mainTable}.continent_id", $key);
            $model->groupBy('country_id');
        } else {
            $relation = $model->getModel()->continent();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$relation->getForeignKeyName()}", "=", "{$foreignTable}.{$mainTableKey}");

            $model->select('continent_id', DB::raw('count(*) as total'));
            $model->groupBy('continent_id');
        }

        if (!empty($otherConditions)) {
            foreach($otherConditions as $col => $val) {
                $model->where($col, $val);
            }
        }
        return $model->orderBy('name')->get();
    }


    /**
     * Get All available locations with agency
     *
     * @param string $param
     * @return void
     */
    public function getAgencyLocations(string $param, string $key)
    {
        $model = $this->getModel()->newModelInstance()
            ->with('country')
            ->with('state')
            ->with('city');

        $mainTable = $model->getModel()->getTable();
        $mainTableKey = $model->getModel()->getKeyName();

        $model->join('users', "{$mainTable}.user_id", "=", "users.id");
        $model->where('users.type', Agency::USER_TYPE);

        if ($param == 'state') {
            $relation = $model->getModel()->state();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$relation->getForeignKeyName()}", "=", "{$foreignTable}.{$mainTableKey}");

            $model->select('state_id', DB::raw('count(*) as total'));
            $model->where("{$mainTable}.country_id", $key);
            $model->where("{$mainTable}.type", UserLocation::MAIN_LOCATION_TYPE);
            $model->groupBy('state_id');

        } elseif ($param == 'city') {
            $relation = $model->getModel()->city();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$relation->getForeignKeyName()}", "=", "{$foreignTable}.{$mainTableKey}");

            $model->select('city_id', DB::raw('count(*) as total'));
            $model->where("{$mainTable}.state_id", $key);
            $model->where("{$mainTable}.type", UserLocation::MAIN_LOCATION_TYPE);
            $model->groupBy('city_id');

        } else {
            $relation = $model->getModel()->country();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$relation->getForeignKeyName()}", "=", "{$foreignTable}.{$mainTableKey}");

            $model->select('country_id', DB::raw('count(*) as total'));
            $model->where("{$mainTable}.type", UserLocation::MAIN_LOCATION_TYPE);
            $model->groupBy('country_id');
        }

        return $model->orderBy("{$foreignTable}.name")->get();
    }
}
