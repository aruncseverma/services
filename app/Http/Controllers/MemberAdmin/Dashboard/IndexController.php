<?php

namespace App\Http\Controllers\MemberAdmin\Dashboard;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Repository\FavoriteRepository;
use App\Models\Favorite;
use App\Repository\UserActivityRepository;
use App\Models\UserActivity;
use App\Repository\UserEmailRepository;
use App\Repository\UserReviewReplyRepository;
use App\Repository\PhotoRepository;

class IndexController extends Controller
{
    /**
     * user favorites repository instance
     *
     * @var App\Repository\FavoriteRepository
     */
    protected $favoriteRepo;

    /**
     * user activity repository instance
     *
     * @var App\Repository\UserActivityRepository
     */
    protected $activityRepo;

    /**
     * user email repository instance
     *
     * @var App\Repository\UserEmailRepository
     */
    protected $emailRepo;

    /**
     * user email repository instance
     *
     * @var App\Repository\UserReviewReplyRepository
     */
    protected $replyRepo;

    /**
     * photo repository instance
     *
     * @var App\Repository\PhotoRepository
     */
    protected $photoRepo;

    /**
     * create instance
     *
     * @param App\Repository\FavoriteRepository $favoriteRepo
     */
    public function __construct(
        FavoriteRepository $favoriteRepo, 
        UserActivityRepository $activityRepo,
        UserEmailRepository $emailRepo,
        UserReviewReplyRepository $replyRepo,
        PhotoRepository $photoRepo
    ) {
        $this->favoriteRepo = $favoriteRepo;
        $this->activityRepo = $activityRepo;
        $this->emailRepo = $emailRepo;
        $this->replyRepo = $replyRepo;
        $this->photoRepo = $photoRepo;

        parent::__construct();
    }

    /**
     * handle dashboard request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle(): View
    {
        $this->setTitle(__('Dashboard'));

        $user = $this->getAuthUser();

        return view('MemberAdmin::dashboard.index', [
            'latestFavoriteEscorts' => $this->getLatestFavoriteEscorts($user),
            'latestFavoriteAgencies' => $this->getLatestFavoriteAgencies($user),
            'latestEmails' => $this->emailRepo->getAllLatestNewEmails($user),
            'latestReviewReplies' => $this->replyRepo->getAllLatestNewReviewReplies($user),
            'latestEscortPhotos' => $this->getFavoriteEscortLatestPhotos($user),
        ]);
    }

    /**
     * get all latest favorite escorts
     *
     * @param  App\Models\User $user
     *
     * @return Illuminate\Support\Collection
     */
    protected function getLatestFavoriteEscorts(User $user): Collection
    {
        $favorites = $this->favoriteRepo->getLatestFavorites($user, Favorite::ESCORT_TYPE, 5);
        foreach ($favorites as $key => $value) {
            $value->escort->setAttribute('profilePhotoUrl', $value->escort->getProfileImage());

            $lastActivity = $this->getLastEscortActivity($value->escort, $user);
            $value->escort->setAttribute('lastActivity', $lastActivity);
        }

        return $favorites;
    }

    /**
     * Get last activity of escort
     * 
     * @param User $escort
     * @param User $member
     * 
     * @return string
     */
    protected function getLastEscortActivity($escort, $member): string
    {
        $activity = $this->activityRepo->getLastEscortActivityForMember($escort->getKey(), $member->getKey());
        if (!$activity) {
            return 'N/A';
        }

        if ($activity->object_type == UserActivity::ESCORT_TYPE) {
            return __('Profile Updated');
        }

        if ($activity->object_type == UserActivity::PHOTO_TYPE) {
            $total = $escort->getTotalNewPhotos();
            return __('Added new photos (:total)', ['total' => $total]);
        }

        if ($activity->object_type == UserActivity::VIDEO_TYPE) {
            $total = $escort->getTotalNewVideos();
            return __('Added new videos (:total)', ['total' => $total]);
        }

        if ($activity->object_type == UserActivity::REVIEW_TYPE) {
            return __('Replied to my review');
        }

        return 'N/A';
    }

    /**
     * get all latest favorite agencies
     *
     * @param  App\Models\User $user
     *
     * @return Illuminate\Support\Collection
     */
    protected function getLatestFavoriteAgencies(User $user): Collection
    {
        $favorites = $this->favoriteRepo->getLatestFavorites($user, Favorite::AGENCY_TYPE, 5);
        foreach ($favorites as $key => $value) {
            $value->agency->setAttribute('profilePhotoUrl', $value->agency->getProfileImage());

            $totalNewEscorts = $value->agency->getTotalNewEscorts();
            $updates = null;
            if (!empty($totalNewEscorts)) {
                $updates = __('Added new models (:total)', ['total' => $totalNewEscorts]);
            }
            $value->agency->setAttribute('updates', $updates);
        }
        return $favorites;
    }

    /**
     * get all latest favorite agencies
     *
     * @param  User $user
     *
     * @return Illuminate\Support\Collection
     */
    protected function getFavoriteEscortLatestPhotos($user): Collection
    {
        $images = collect();
        $favorites = $this->photoRepo->getFavoriteEscortLatestPhotos($user);

        foreach($favorites as $fav) {
            foreach ($fav->escort->photos as $photo) {
                $images->push(route(
                    'common.photo',
                    [
                        'path' => $photo->path,
                        'photo' => $photo->getKey(),
                    ]
                ));
            }
        }
        return $images;
    }
}
