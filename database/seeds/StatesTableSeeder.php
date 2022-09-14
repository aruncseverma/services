<?php

use Illuminate\Database\Seeder;
use App\Repository\StateRepository;
use App\Repository\CountryRepository;

class StatesTableSeeder extends Seeder
{
    /**
     * state repository instance
     *
     * @var App\Repository\StateRepository
     */
    protected $stateRepository;

    /**
     * country repository instance
     *
     * @var App\Repository\CountryRepository
     */
    protected $countryRepository;

    /**
     * create instance
     *
     * @param App\Repository\StateRepository   $stateRepository
     * @param App\Repository\CountryRepository $countryRepository
     */
    public function __construct(StateRepository $stateRepository, CountryRepository $countryRepository)
    {
        $this->stateRepository = $stateRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getStates() as $state) {
            $country = $this->countryRepository->findBy(['code' => $state['country_code']]);
            if ($country) {
                $this->stateRepository->saveState(
                    [
                        'name' => $state['state'],
                        'is_active' => true,
                    ],
                    $country
                );
            }
        }
    }

    /**
     * get states list
     *
     * @return array
     */
    protected function getStates() : array
    {
        return require_once __DIR__ . '/../data/states.php';
    }
}
