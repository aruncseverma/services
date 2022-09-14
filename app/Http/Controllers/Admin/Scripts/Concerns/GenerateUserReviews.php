<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use Faker\Factory as Faker;
use App\Models\Escort;
use App\Repository\UserRepository;
use App\Repository\UserReviewRepository;

trait GenerateUserReviews
{
    protected $minReview = 1;
    protected $maxReview = 100;

    /**
     * Generate user reviews
     * 
     * @return array
     */
    private function generateReviews()
    {
        $repo = app(UserRepository::class);
        $users = $repo->getBuilder()
            ->select('id')
            ->whereNotIn('type', [Escort::USER_TYPE])
            ->get();
        $userIds = [];
        if (!empty($users)) {
            foreach ($users as $user) {
                $userIds[] = $user->getKey();
            }
        }

        $faker = Faker::create();
        $totalReviews = $faker->numberBetween($this->minReview, $this->maxReview);
        $countReviews = 0;
        $reviews = [];
        if (!empty($userIds)) {
            $ratings = [1.0, 2.0, 3.0, 4.0, 5.0];
            // foreach($userIds as $userId) {
            //     //id, object_id, user_id, content, rating, is_approved, is_denied, created_at, updated_at
            //     $reviews[] = [
            //         //'object_id' => $escortId,
            //         'user_id' => $userId,
            //         'content' => $this->getRandomBoolean() ? $faker->sentence : $faker->paragraph,
            //         'rating' => $this->getRandomValue($ratings),
            //         'is_approved' => true,
            //         'is_denied' => false,
            //     ];
            //     ++$countReviews;
            // }
            if ($countReviews < $totalReviews) {
                for ($x = $countReviews; $x < $totalReviews; ++$x) {
                    $reviews[] = [
                        //'object_id' => $escortId,
                        'user_id' => $this->getRandomValue($userIds),
                        'content' => $this->getRandomBoolean() ? $faker->sentence : $faker->paragraph,
                        'rating' => $this->getRandomValue($ratings),
                        'is_approved' => true,
                        'is_denied' => false,
                    ];
                }
            }
        }
        return $reviews;
    }

    /**
     * save user reviews
     *
     * @param  App\Models\Escort $user
     * @param array $reviews
     *
     * @return void
     */
    private function saveUserReviews(Escort $user, $reviews): void
    {
        $repository = app(UserReviewRepository::class);
        foreach ($reviews as $data) {
            $data['object_id'] = $user->getKey();
            $repository->save($data);
        }
    }
}