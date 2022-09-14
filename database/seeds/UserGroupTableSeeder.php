<?php
/**
 * user group table seeder class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

use Illuminate\Database\Seeder;
use App\Repository\UserGroupRepository;

class UserGroupTableSeeder extends Seeder
{
    /**
     * repository instance
     *
     * @var App\Repository\UserGroupRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\UserGroupRepository $repository
     */
    public function __construct(UserGroupRepository $repository)
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
        foreach ($this->groups() as $group) {
            $this->repository->save($group);
        }
    }

    /**
     * pre defined groups
     *
     * @return array
     */
    protected function groups() : array
    {
        return [
            [
                'name' => 'Basic',
                'is_active' => true,
                'is_default' => true,
            ],
            [
                'name' => 'Silver',
                'is_active' => true,
                'is_default' => false,
            ],
            [
                'name' => 'Gold',
                'is_active' => true,
                'is_default' => false,
            ]
        ];
    }
}
