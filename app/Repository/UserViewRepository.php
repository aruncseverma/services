<?php

namespace App\Repository;

use App\Models\UserView;
use App\Models\User;
use Carbon\Carbon;

class UserViewRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserView $model
     */
    public function __construct(UserView $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\User         $user
     * @param  App\Models\UserView $model
     *
     * @return App\Models\UserView
     */
    public function store(array $attributes, User $user, UserView $model = null) : UserView
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        $model->user()->associate($user);

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }

    /**
     * find view by ip that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\UserView|null
     */
    public function findViewByIp(string $id, User $user) : ?UserView
    {
        return $user->views()->where('ip_address', $id)->first();
    }

    /**
     * get total views of user
     *
     * @param int $userId
     * @return integer
     */
    public function getTotalViewsByUserId($userId) : int
    {
        return $this->getBuilder()
            ->where('user_id', $userId)
            ->count();
    }

    /**
     * get total views of user
     *
     * @param  App\Models\User $user
     * @return integer
     */
    public function getTotalViews(User $user) : int
    {
        return $user->totalViews();
    }

    /**
     * find today view by ip that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\UserView|null
     */
    public function findTodayViewByIp(string $id, User $user): ?UserView
    {
        return $user->views()
            ->whereDate(UserView::CREATED_AT, Carbon::today())
            ->where('ip_address', $id)
            ->first();
    }

    /**
     * Get visitor graph data
     * 
     * @param User $user
     * @param string|null $dataType
     * @param string|null $periodType
     * @return array|null
     */
    public function getVisitorGraphData($user, $dataType = null, $periodType = null) : ?array
    {
        $allowedDataTypes = ['device', 'device_type', 'platform', 'browser'];
        if (!in_array($dataType, $allowedDataTypes)) {
            $dataType = 'device_type';
        }

        if (empty($periodType)) {
            $periodType = 'today';
        }
        $fromDate = '';
        $toDate = '';
        $isReturnNull = false;
        if (!empty($periodType)) {
            switch ($periodType) {
                case 'today':
                    $fromDate = $toDate = Carbon::today();
                    $isReturnNull = true;
                    break;
                case 'yesterday':
                    $fromDate = $toDate = Carbon::yesterday();
                    $isReturnNull = true;
                    break;
                case 'last_week':
                    $fromDate = Carbon::today()->startOfWeek()->subWeek();
                    $toDate = $fromDate->copy()->endOfWeek();
                    break;
                case 'last_14_days':
                    $fromDate = Carbon::today()->subDays(14);
                    $toDate = Carbon::today();
                    break;
                case 'last_30_days':
                    $fromDate = Carbon::today()->subDays(30);
                    $toDate = Carbon::today();
                    break;
            }
        }
    
        $views = $user->views()
            ->selectRaw($dataType .' AS data_type')
            ->selectRaw('COUNT(DISTINCT ip_address) AS data_value')
            ->selectRaw('DATE(created_at) AS period')
            ->where(function($q) use ($fromDate, $toDate) {
                if (!empty($fromDate) && !empty($toDate)) {
                    $q->whereDate(UserView::CREATED_AT, '>=', $fromDate);
                    $q->whereDate(UserView::CREATED_AT, '<=', $toDate);
                }
            })
            ->groupBy($dataType, \DB::raw('DATE(created_at)'))
            ->orderByRaw('DATE(created_at) asc')
            ->get();

        $periodsData = [];
        $dataTypes = [];

        // generate all dates
        if (!empty($fromDate) && !empty($toDate)) {
            $toDate->addDay(1); // to include end date in DatePeriod
            $period = new \DatePeriod(
                new \DateTime($fromDate->format('Y-m-d')),
                new \DateInterval('P1D'),
                new \DateTime($toDate->format('Y-m-d'))
            );
            foreach ($period as $key => $value) {
                $date = $value->format('Y-m-d');
                $periodsData[$date] = ['period' => $date];
            }
        }

        if ($views->count()) {
            foreach ($views as $view) {
                if (empty($view->data_type)) {
                    continue;
                }
                // add to list if not exits
                if (!isset($periodsData[$view->period])) {
                    $periodsData[$view->period] = [];
                    $periodsData[$view->period]['period'] = $view->period;
                }
                $periodsData[$view->period][$view->data_type] = $view->data_value;

                // add to data types
                $dataTypes[$view->data_type] = 0;
            }
        } elseif ($isReturnNull) {
            return null;
        }

        if (empty($dataTypes)) {
            $dataTypes = ['mobile' => 0, 'desktop' => 0];
        }
        // include all data types 
        foreach ($periodsData as $k => $v) {
            $periodsData[$k] = array_merge($dataTypes, $v);
        }

        return [
            'data' => json_encode(array_values($periodsData)),
            'keys' => '["' . implode('","', array_keys($dataTypes)) . '"]',
        ];
    }

    /**
     * get all visitor graph selection
     *
     * @return array
     */
    public function getVisitorGraphSelection() : array
    {
        return [
            'today' => __('Today'),
            'yesterday' => __('Yesterday'),
            'last_week' => __('Last Week'),
            'last_14_days' => __('Last 14 Days'),
            'last_30_days' => __('Last 30 Days')
        ];
    }
}
