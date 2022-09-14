<?php
/**
 * Contains transaction for vip membership plans
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Repository;

use App\Models\Biller;
use App\Models\Membership;
use App\Models\User;
use App\Models\VipSubscription;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class VipMembershipRepository extends Repository
{
    /**
     * Create instance of the repository
     */
    public function __construct(VipSubscription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * Saves the data for vip membership
     * of the escort
     *
     * @param array $params
     * @param User $user
     * @param Membership $plan
     * @param Biller $biller
     * @param VipSubscription $model
     *
     * @return VipSubscription
     */
    public function store(array $params, User $user, Membership $plan, Biller $biller, VipSubscription $model = null) : VipSubscription
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        $model->user()->associate($user);
        $model->biller()->associate($biller);
        $model->membership()->associate($plan);

        return parent::save($params, $model);
    }

    /**
     * Get Last inserted Id
     *
     * @return int
     */
    public function getLastInserted()
    {
        $last = $this->model->orderBy('created_at', 'DESC')->first();
        return ($last != null) ? $last->id : 0;
    }

    /**
     * search for paginated result set
     *
     * @param integer $limit
     * @param array $params
     *
     * @return LengthAwarePaginator
     */
    public function search(int $limit, array $params = []) : LengthAwarePaginator
    {
        $builder = $this->createSearchBuilder($params);

        return $builder->paginate($limit)->appends($params);
    }

    /**
     * Undocumented function
     *
     * @param array $param
     * @return void
     */
    public function getLatest(array $param = [])
    {
        $builder = $this->createSearchBuilder($param);
        return $builder->orderBy('id', 'DESC')->first();
    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @return VipSubscription
     */
    public function fetch($id) : VipSubscription
    {
        $builder = $this->getBuilder()->with('user');
        return $builder->find($id);
    }

    /**
     * create search builder instance
     *
     * @param array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function createSearchBuilder(array $params) : Builder
    {
        $builder = $this->getBuilder()->with('user')
                    ->with('membership')
                    ->with('biller')
                    ->with('payment')
                    ->with('payment.admin');
        
        if (isset($params['plan_id']) && ($plan = $params['plan_id'])) {
            $builder->where('plan_id', $plan);
        }

        if (isset($params['payment_id']) && ($biller = $params['payment_id'])) {
            $builder->where('payment_id', $biller);
        }

        if (isset($params['user_id']) && ($user = $params['user_id'])) {
            $builder->where('user_id', $user);
        }

        if (isset($params['vip_status']) && ($status = $params['vip_status'])) {
            $builder->where('vip_status', $status);
        }

        if (isset($params['order_id']) && ($order = $params['order_id'])) {
            $builder->where('order_id', $order);
        }

        $builder->where('vip_status', '<>', 'D')    // Not Deleteed
                ->where('vip_status', '<>', 'E')    // Not Expired
                ->where('status', '<>', 'R')        // Not Revoked
                ->where('status', '<>', 'X');       // Not Cancelled

        return $builder;
    }

    /**
     * Updates subscription
     *
     * @param array $param
     * @param integer $id
     *
     * @return void
     */
    public function updateStatus(array $param, int $id)
    {
        $purchase = $this->find($id);
        $purchase->update($param);

        return $purchase->save();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getTotalSales()
    {
        $model = $this->createSearchBuilder([]);

        $model->where('status', 'C');
        $result = $model->get();

        $sales = [];
        $recent = [];
        foreach($result as $purchases) {

            $currency = $purchases->membership->currency->name;

            if (!isset($sales[$currency])) {
                $sales[$currency] = 0.00;
                $recent[$currency] = 0.00;
            }

            $currentDate = new Carbon();
            if ($currentDate->diffInDays($purchases->date_paid) <= 2) {
                $recent[$currency] += $purchases->membership->total_price;
            }

            $sales[$currency] += $purchases->membership->total_price;
        }

        $overallSales['recent'] = $recent;
        $overallSales['total'] = $sales;

        return $overallSales;
    }
}