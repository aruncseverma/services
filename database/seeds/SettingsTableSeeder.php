<?php

use Illuminate\Database\Seeder;
use App\Repository\SettingRepository;

class SettingsTableSeeder extends Seeder
{
    /**
     * repository instance
     *
     * @var App\Repository\Settings\SettingRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\Settings\SettingRepository $repository
     */
    public function __construct(SettingRepository $repository)
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
        foreach ($this->getDefaultSettings() as $group => $settings) {
            foreach ($settings as $setting => $value) {
                $this->repository->save([
                    'group' => $group,
                    'key'   => $setting,
                    'value' => $value
                ]);
            }
        }
    }

    /**
     * get site default settings array
     *
     * @return void
     */
    protected function getDefaultSettings()
    {
        return [
            'site' => [
                'name'      => 'Site Name',
                'is_maintenance' => 0,
                'page_size'      => 10,
            ],
            'admin' => [
                'page_size' => 10,
            ]
        ];
    }
}
