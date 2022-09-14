<?php
/**
 * repository class for eloquent model escort schedule
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Escort;
use App\Models\EscortSchedule;

class EscortScheduleRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\EscortSchedule $model
     */
    public function __construct(EscortSchedule $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * creates/update escort repository
     *
     * @param  array                     $attributes
     * @param  App\Models\Escort         $escort
     * @param  App\Models\EscortSchedule $model
     *
     * @return App\Models\EscortSchedule
     */
    public function store(array $attributes, Escort $escort, EscortSchedule $model = null) : EscortSchedule
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        $model->escort()->associate($escort);

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }

    /**
     * get escort schedule from repository using its day
     *
     * @param  string            $day
     * @param  App\Models\Escort $escort
     *
     * @return null|App\Models\EscortSchedule
     */
    public function getScheduleFromEscortByDay(string $day, Escort $escort)
    {
        return $escort->schedules()->where(['day' => $day])->first();
    }
}
