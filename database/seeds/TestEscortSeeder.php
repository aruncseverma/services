<?php

use App\Models\Escort;
use App\Repository\EscortRepository;
use Illuminate\Database\Seeder;

class TestEscortSeeder extends Seeder
{

    public function __construct(EscortRepository $repo)
    {
        $this->repository = $repo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->repository->save([
            'email' => 'escort@test.com',
            'password' => 'test1234',
            'username'  => 'chisaki',
            'name' => 'Miyazaki',
            'is_active' => true,
            'type' => Escort::USER_TYPE,
        ]);
    }
}
