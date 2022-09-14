<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use App\Repository\ContinentRepository;
use App\Repository\CountryRepository;
use App\Repository\StateRepository;
use App\Repository\CityRepository;

use App\Models\UserLocation;

use App\Models\Escort;
use App\Repository\UserLocationRepository;

trait GenerateUserLocations
{
    /**
     * Generate random location
     * 
     * @return array
     */
    private function getRandomUserLocation()
    {
        // continent
        $repo = app(ContinentRepository::class);
        $continent = $repo->getBuilder()
            ->select('id')
            ->inRandomOrder()
            ->first();
        $continentId = $continent ? $continent->id : null;

        // country
        $repo = app(CountryRepository::class);
        $country = $repo->getBuilder()
            ->select('id')
            ->where('continent_id', $continentId)
            ->inRandomOrder()
            ->first();
        $countryId = $country ? $country->id : null;

        // state
        $repo = app(StateRepository::class);
        $state = $repo->getBuilder()
            ->select('id')
            ->where('country_id', $continentId)
            ->inRandomOrder()
            ->first();
        $stateId = $state ? $state->id : null;

        // city
        $repo = app(CityRepository::class);
        $city = $repo->getBuilder()
            ->select('id')
            ->where('state_id', $continentId)
            ->inRandomOrder()
            ->first();
        $cityId = $city ? $city->id : null;

        $data = [
            'continent_id' => $continentId,
            'country_id' => $countryId,
            'state_id' => $stateId,
            'city_id' => $cityId,
        ];

        //id, user_id, type, continent_id, country_id, state_id, city_id
        return $data;
    }

    /**
     * Generate user main location
     * 
     * @return array
     */
    private function generateUserLocationMain()
    {
        $mainLocation = $this->getRandomUserLocation();
        $mainLocation['type'] = UserLocation::MAIN_LOCATION_TYPE;
        return $mainLocation;
    }

    /**
     * Generate user additional locations
     * 
     * @return array
     */
    private function generateUserLocationAdditional()
    {
        $additionalLocations = [];
        $totalAdditionalLocations = $this->getRandomValue([1, 2, 3, 4, 5]);
        if ($totalAdditionalLocations > 0) {
            for ($x = 0; $x < $totalAdditionalLocations; ++$x) {
                $location = $this->getRandomUserLocation();
                $location['type'] = UserLocation::ADDITIONAL_LOCATION_TYPE;
                $additionalLocations[$x] = $location;
            }
        }
        return $additionalLocations;
    }

    /**
     * save user locations
     *
     * @param  App\Models\Escort $user
     * @param array $data
     *
     * @return void
     */
    private function saveUserLocation(Escort $user, $data): void
    {

        $repository = app(UserLocationRepository::class);
        // save it
        $repository->store(
            $data,
            $user
        );
    }
}