<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use App\Models\Escort;
use App\Models\UserGroup;
use App\Repository\UserProfileValidationRepository;

trait GenerateProfileValidation
{
    /**
     * Generate profile validation
     * 
     * @return array
     */
    private function generateProfileValidation()
    {
        if ($this->getRandomBoolean()) {
            $groups = [
                UserGroup::SILVER_GROUP_ID,
                UserGroup::GOLD_GROUP_ID
            ];

            $randomGroup = $this->getRandomValue($groups);
            return [
                'user_group_id' => $randomGroup,
                'is_approved' => 1
            ];
        }

        return false;
    }

    /**
     * save user profile validation
     *
     * @param  App\Models\Escort $user
     * @param array $userProfileValidation
     *
     * @return void
     */
    private function saveUserProfileValidation(Escort $user, $userProfileValidation): void
    {
        //$repository = app(UserProfileValidationRepository::class);
        // $userProfileValidation['user_id'] = $user->getKey();
        // $repository->save($userProfileValidation);

        $user->user_group_id = $userProfileValidation['user_group_id'];
        $user->save();
    }
}