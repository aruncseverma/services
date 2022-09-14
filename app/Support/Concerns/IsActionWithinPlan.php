<?php
/**
 * helper methods for checking if user acts
 * within their purchased membership subscription
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Support\Concerns;

use App\Models\User;
use App\Repository\PhotoRepository;
use App\Repository\UserVideoRepository;

trait IsActionWithinPlan
{

    /**
     * basic membership plan can only upload
     * 3 maximum images
     *
     * @var integer
     */
    protected $imageUploadLimit = 3;

    /**
     * basic membership plan can only upload
     * 5 maximum videos
     *
     * @var integer
     */
    protected $videoUploadLimit = 3;

    /**
     * basic membership plan can only view
     * up to 50 emails
     *
     * @var integer
     */
    protected $emailLimit = 50;

    /**
     * Checks if the user is still within
     * the limit of his/her membership plan for image uploads
     *
     * @param User|null $user
     * @return boolean
     */
    protected function isImageUploadLimitReached(?User $user)
    {
        if ($user->user_group_id == null) {
            $photos = app(PhotoRepository::class);
            $photoCount = $photos->fetchAllPhotosByUser($user->getKey())->count();

            if ($photoCount >= $this->imageUploadLimit) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the user is still within
     * the limit of his/her membership plan for video uploads
     *
     * @param User|null $user
     * @return boolean
     */
    protected function isVideoUploadLimitReached(?User $user)
    {
        if ($user->user_group_id == null) {
            $videos = app(UserVideoRepository::class);
            $videoCount = $videos->getUserPublicVideos($user->getKey())->count();

            if ($videoCount >= $this->videoUploadLimit) {
                return true;
            }
        }

        return false;
    }
}