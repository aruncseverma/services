<?php

use Illuminate\Database\Seeder;
use App\Repository\CurrencyRepository;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * repository instance
     *
     * @var App\Repository\CurrencyRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\CurrencyRepository $repository
     */
    public function __construct(CurrencyRepository $repository)
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
        foreach ($this->defaultCurrencies() as $currency) {
            $this->repository->save($currency);
        }
    }

    /**
     * get default currencies to be seeded
     *
     * @return array
     */
    protected function defaultCurrencies() : array
    {
        return [
            [
                'name' => 'USD',
                'is_default' => false,
                'rate' => 1.00,
                'is_active' => true,
                'code' => 'USD',
                'symbol_right' => '$'
            ],
            [
                'name' => 'EURO',
                'is_default' => true,
                'rate' => 1.00,
                'is_active' => true,
                'code' => 'EUR',
                'symbol_left' => '€'
            ],
        ];
    }
}
