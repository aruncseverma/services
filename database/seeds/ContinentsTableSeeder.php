<?php

use Illuminate\Database\Seeder;
use App\Repository\ContinentRepository;

class ContinentsTableSeeder extends Seeder
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
     * @param App\Repository\ContinentRepository $repository
     */
    public function __construct(ContinentRepository $repository)
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
        foreach ($this->getContinents() as $continent) {
            $this->repository->save([
                'name' => $continent['name'],
                'code' => $continent['code'],
            ]);
        }
    }

    /**
     * get continents list
     *
     * @return void
     */
    protected function getContinents()
    {
        return require_once __DIR__ . '/../data/continents.php';
    }
}
