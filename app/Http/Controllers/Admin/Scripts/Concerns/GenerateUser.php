<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use Faker\Factory as Faker;
use App\Models\Escort;
use App\Repository\EscortRepository;

trait GenerateUser
{
    /**
     * Generate user
     * 
     * @return array
     */
    private function generateUser()
    {
        $faker = Faker::create();

        $password = 'password';
        $genders = ['M', 'F', 'M'];
        $gender = $this->getRandomValue($genders);

        //$max = 'now';
        $time = strtotime("-18 year", time());
        //$date = date("Y-m-d", $time);
        $max = $time;
        $birthdate = $faker->date($format = 'Y-m-d', $max);

        $attributes = [
            'email'     => $faker->email,
            'username'  => $faker->username,
            'name'      => $faker->name,
            'is_active' => true,
            'type'      => Escort::USER_TYPE,
            'is_newsletter_subscriber' => (bool)random_int(0, 1),
            'password' => $password,

            'is_verified' => true,
            'is_approved' => true,
            'gender' => $gender,
            'phone' => $faker->phoneNumber, // profile > contact information > contact number
            'birthdate' => $birthdate,
        ];

        return $attributes;
    }

    /**
     * save user
     *
     * @param array $attributes
     *
     * @return Escort
     */
    private function saveUser($attributes)
    {
        $repository = app(EscortRepository::class);
        $user = $repository->save($attributes);
        return $user;
    }
}