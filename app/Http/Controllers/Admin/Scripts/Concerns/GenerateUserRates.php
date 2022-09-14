<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use Faker\Factory as Faker;
use App\Models\Escort;
use App\Support\Concerns\NeedsCurrencies;
use App\Support\Concerns\NeedsRateDurations;
use App\Repository\EscortRateRepository;

trait GenerateUserRates
{
    use NeedsCurrencies, NeedsRateDurations;

    /**
     * Generate user rates
     * 
     * @return array
     */
    private function generateUserRates()
    {
        $faker = Faker::create();

        $currencies = $this->getCurrencies();
        //$randomCurrency = $currencies->random();
        $durations = $this->getRateDurations();
        $escortDurations = [];
        $min = 1000;
        $max = 9000;
        if (!empty($currencies) && !empty($durations)) {
            foreach ($currencies as $currency) {
                foreach ($durations as $duration) {
                    $escortDurations[] = [
                        'rate_duration_id' => $duration->getKey(),
                        'currency_id' => $currency->getKey(), //$randomCurrency->getKey(),
                        'incall' => $faker->numberBetween($min, $max),
                        'outcall' => $faker->numberBetween($min, $max),
                    ];
                }
            }
        }
        return $escortDurations;
    }

    /**
     * save user rates
     *
     * @param  App\Models\Escort $user
     * @param array $userRates
     *
     * @return void
     */
    private function saveUserRates(Escort $user, $userRates): void
    {
        $repository = app(EscortRateRepository::class);
        foreach ($userRates as $data) {
            $data['user_id'] = $user->getKey();
            $repository->save($data);
        }
    }
}