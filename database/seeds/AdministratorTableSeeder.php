<?php

use App\Models\Administrator;
use Illuminate\Database\Seeder;
use App\Repository\AdministratorRepository;

class AdministratorTableSeeder extends Seeder
{
    /**
     * repository instance
     *
     * @var App\Repository\AdministratorRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\AdministratorRepository $repository
     */
    public function __construct(AdministratorRepository $repository)
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
        $this->repository->save([
            'email' => 'admin@test.com',
            'password' => 'test1234',
            'username'  => 'admin',
            'name' => 'Administrator',
            'is_active' => true,
            'type' => Administrator::USER_TYPE,
        ]);
    }
}
