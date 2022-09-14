<?php

use Illuminate\Database\Seeder;
use App\Repository\CountryRepository;
use App\Repository\ContinentRepository;

class CountriesTableSeeder extends Seeder
{
    /**
     * repository instance
     *
     * @var App\Repository\ContinentRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\CountryRepository $repository
     */
    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getCountries() as $country) {
            $this->repository->save([
                'code' => $country['code'],
                'name' => $country['name'],
                'is_active' => true,
                'continent_id' => $this->getContinent($country['continent_code'])->getKey(),
            ]);
        }
    }

    protected function getContinent($code)
    {
        return app(ContinentRepository::class)->findBy(['code' => $code]);
    }

    /**
     * get countries list
     *
     * @return array
     */
    protected function getCountries()
    {
        return require_once __DIR__ . '/../data/countries.php';
    }
}
