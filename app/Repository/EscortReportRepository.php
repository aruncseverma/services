<?php
/**
 * escort reports repository class
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Repository;

use App\Models\Escort;
use App\Models\EscortReport;

class EscortReportRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\EscortReport $model
     */
    public function __construct(EscortReport $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\Escort         $escort
     * @param  App\Models\EscortReport $model
     *
     * @return App\Models\EscortReport
     */
    public function store(array $attributes, Escort $escort, EscortReport $model = null) : EscortReport
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
     * find report by id that is attached from the escort
     *
     * @param  string $field
     * @param  App\Models\Escort $escort
     *
     * @return App\Models\EscortReport|null
     */
    public function findReportById(string $id, Escort $escort) : ?EscortReport
    {
        return $escort->reports()->where('id', $id)->first();
    }
}
