<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdministratorTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ContinentsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(RateDurationsTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(ServiceCategoriesTableSeeder::class);
        $this->call(UserGroupTableSeeder::class);
        $this->call(BillersAndPackagesSeeder::class);
        $this->call(TranslationsTableSeeder::class);
    }
}
