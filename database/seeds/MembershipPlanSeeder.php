<?php

use App\Repository\MembershipPlanRepository;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{

    /**
     * Undocumented function
     *
     * @param MembershipPlanRepository $repo
     */
    public function __construct(MembershipPlanRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $membership = $this->plans();

        foreach($membership as $plan) {
            $this->repo->save($plan);
        }
    }

    /**
     * default value for membership plans
     *
     * @return array
     */
    private function plans()
    {
        return [
            [
                'currency_id' => 1,
                'months' => 1,
                'discount' => 0.00,
                'total_price' => 10.00,
                'price_per_month' => 10.00,
                'is_active' => 1
            ],
            [
                'currency_id' => 1,
                'months' => 3,
                'discount' => 3.00,
                'total_price' => 27.00,
                'price_per_month' => 9.00,
                'is_active' => 1
            ],
            [
                'currency_id' => 1,
                'months' => 6,
                'discount' => 12.00,
                'total_price' => 48.00,
                'price_per_month' => 8.00,
                'is_active' => 1
            ],
            [
                'currency_id' => 1,
                'months' => 12,
                'discount' => 40.00,
                'total_price' => 80.00,
                'price_per_month' => 6.66,
                'is_active' => 1
            ]
        ];
    }
}
