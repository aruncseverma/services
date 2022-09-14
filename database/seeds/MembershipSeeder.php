<?php
/**
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */

use Illuminate\Database\Seeder;
use App\Repository\MembershipPlanRepository;

class MembershipSeeder extends Seeder
{
    /**
     * Undocumented function
     */
    public function __construct(MembershipPlanRepository $repository)
    {
        $this->membershipRepository = $repository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getPlans() as $key => $plan) {
            $this->membershipRepository->save($plan);
        }
    }

    /**
     * Initial Membership plans
     *
     * @return array
     */
    private function getPlans()
    {
        return [
            [
                'currency'          => 'USD',
                'months'            => 1,
                'discount'          => 0.00,
                'total_price'       => 30.00,
                'price_per_month'   => 30.00,
                'is_active'         => true
            ],
            [
                'currency'          => 'USD',
                'months'            => 3,
                'discount'          => 10.00,
                'total_price'       => 80,
                'price_per_month'   => 26.66,
                'is_active'         => true
            ],
            [
                'currency'          => 'USD',
                'months'            => 12,
                'discount'          => 60.00,
                'total_price'       => 300.00,
                'price_per_month'   => 25.00,
            ]
        ];
    }
}
