<?php
/**
 * escort bookings repository class
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Repository;

use App\Models\Escort;
use App\Models\EscortBooking;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EscortBookingRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\EscortBooking $model
     */
    public function __construct(EscortBooking $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\Escort         $escort
     * @param  App\Models\EscortBooking $model
     *
     * @return App\Models\EscortBooking
     */
    public function store(array $attributes, Escort $escort, EscortBooking $model = null) : EscortBooking
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
     * find booking by id that is attached from the escort
     *
     * @param  string $field
     * @param  App\Models\Escort $escort
     *
     * @return App\Models\EscortBooking|null
     */
    public function findBookingById(string $id, Escort $escort) : ?EscortBooking
    {
        return $escort->bookings()->where('id', $id)->first();
    }

    /**
     * search for models with paginated results
     *
     * @param  integer $limit
     * @param  array   $search
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $pageSize, array $params = []) : LengthAwarePaginator
    {
        $builder = $this->createEscortBookingBuilder($params);

        if (isset($params['user_id'])) {
            unset($params['user_id']);
        }

        // change page param
        $pageParam = (isset($params['page_param'])) ? $params['page_param'] : 'page';
        unset($params['page_param']);

        return $builder->paginate($pageSize, ['*'], $pageParam)->appends($params);
    }

    /**
     * creates escort reviews collection query builder
     *
     * @param  array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createEscortBookingBuilder(array $params) : Builder
    {
        // merge default params
        $params = array_merge(
            [
                'sort'       => $this->getModel()->getKeyName(),
                'sort_order' => 'desc'
            ],
            $params
        );

        // get model query builder
        $builder = $this->getBuilder();

        // user id where clause
        if (isset($params['user_id'])) {
            $builder->where('user_id', (int) $params['user_id']);
        }

        if (isset($params['id'])) {
            $builder->where($this->getModel()->getKeyName(), $params['id']);
        }

        if (isset($params['is_latest'])) {
            $builder->whereDate(EscortBooking::CREATED_AT, Carbon::today())->orderBy('created_at', 'DESC');
        }

        // create sort clause
        $this->createBuilderSort($builder, $params['sort'], $params['sort_order'], []);

        return $builder;
    }

    /**
     * Undocumented function
     *
     * @param string $id
     * @param Escort $escort
     */
    public function getAllBookingsByEscort(Escort $escort)
    {
        return $escort->bookings()->paginate();
    }
}
