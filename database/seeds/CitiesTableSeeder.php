<?php

use Illuminate\Database\Seeder;
use App\Repository\CityRepository;
use App\Repository\StateRepository;

class CitiesTableSeeder extends Seeder
{
    /**
     * city repository instance
     *
     * @var App\Repository\CityRepository
     */
    protected $cityRepository;

    /**
     * country repository instance
     *
     * @var App\Repository\StateRepository
     */
    protected $stateRepository;

    /**
     * create instance
     *
     * @param App\Repository\CityRepository   $cityRepository
     * @param App\Repository\StateRepository  $countryRepository
     */
    public function __construct(CityRepository $cityRepository, StateRepository $stateRepository)
    {
        $this->cityRepository  = $cityRepository;
        $this->stateRepository = $stateRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getCities() as $city) {
            $state = $this->stateRepository->findBy(['name' => $city['state']]);
            if ($state) {
                $this->cityRepository->saveCity(
                    [
                        'name' => $city['city'],
                        'is_active' => true,
                    ],
                    $state
                );
            }
        }
    }

    /**
     * get cities list
     *
     * @return array
     */
    protected function getCities() : array
    {
        return require_once __DIR__ . '/../data/cities.php';
    }
}
