<?php

use Illuminate\Database\Seeder;
use App\Repository\CountryRepository;
use App\Repository\LanguageRepository;

class LanguagesTableSeeder extends Seeder
{
    /**
     * create instance
     *
     * @param App\Repository\LanguageRepository $languageRepository
     * @param App\Repository\CountryRepository  $countryRepository
     */
    public function __construct(LanguageRepository $languageRepository, CountryRepository $countryRepository)
    {
        $this->languageRepository = $languageRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->languageRepository->save([
            'code' => 'en',
            'name' => 'English (United States)',
            'is_active' => true,
            'country_id' => $this->countryRepository->findBy(['code' => 'us'])->getKey(),
        ]);
    }
}
