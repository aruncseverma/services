<?php
/**
 * escort's photo model repository class
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\Photo;
use App\Models\PhotoFolder;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class PhotoRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Photo $model
     */
    public function __construct(Photo $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\Photo|null
     */
    public function find($id)
    {
        return $this->getBuilder()
            ->where($this->getModel()->getKeyName(), $id)
            ->first();
    }

    /**
     *  Fetches all photos by the user
     *
     *  @param int $userId
     *  @return array(App\Models\Photo) | null
     */
    public function fetchAllPhotosByUser($userId)
    {
        return $this->getBuilder()
            ->where('user_id', $userId)
            ->get();
    }

    /**
     *  Fetches photos within the given folder id
     *
     *  @param int $folderId
     *  @return array(App\Model\Photos) | null
     */
    public function fetchPhotosByFolder($folderId)
    {
        return $this->getBuilder()
            ->where('folder_id', $folderId)
            ->get();
    }

    /**
     *  Fetch photo by type
     *
     *  @param String $type
     *  @param int $userId
     *  @return array(App\Models\Photo) | null
     */
    public function fetchPhotoByType($type, $userId)
    {
        return $this->getBuilder()
            ->where('type', $type)
            ->get();
    }

    /**
     *  Fetches the current primary photo of the user
     *
     *  @param String userId
     *  @return (App\Model\Photo) | null
     */
    public function fetchPrimaryPhoto($userId)
    {
        return $this->getBuilder()
            ->where('user_id', $userId)
            ->where('is_primary', 1)
            ->first();
    }

    /**
     *  Deletes Image
     *
     *  @param int $photoId
     *  @return boolean
     */
    public function remove($photoId)
    {
        return $this->getBuilder()
            ->where('id', $photoId)
            ->delete();
    }

    /**
     *  Returns all user's public image primary status to 0
     *
     *  @param int $userId
     *  @return boolean
     */
    public function resetPrimaryStatus($userId)
    {
        return $this->getBuilder()
            ->where('user_id', $userId)
            ->update([
                'is_primary'    => 0
            ]);
    }

    /**
     *  Set image as primary
     *
     *  @param int $photoId
     *  @return boolean
     */
    public function setAsPrimary($photoId)
    {
        return $this->getBuilder()
            ->where('id', $photoId)
            ->update(['is_primary'=> 1]);
    }

    /**
     * store photo information to repository
     *
     * @param  array                   $attributes
     * @param  App\Models\User        $user
     * @param  App\Models\PhotoFolder $folder
     * @param  App\Models\Photo|null  $model
     *
     * @return App\Models\Photo
     */
    public function store(array $attributes, User $user, ?PhotoFolder $folder = null, ?Photo $model = null) : Photo
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // associate
        $model->user()->associate($user);
        $model->folder()->associate($folder);

        return parent::save($attributes, $model);
    }

    /**
     * get all user private photos
     *
     * @param  App\Models\User $user
     *
     * @return Illuminate\Support\Collection
     */
    public function getUserPrivatePhotos(User $user) : Collection
    {
        return $this->getBuilder()
            ->where($this->getModel()->user()->getForeignKeyName(), $user->getKey())
            ->where('type', Photo::PRIVATE_PHOTO)
            ->get();
    }

    /**
     * Get all favorite escorts latest photos
     * 
     * @param User $user
     * @return Collection
     */
    public function getFavoriteEscortLatestPhotos(User $user) : Collection
    {
        return $user->favoriteEscorts()
            ->with([
                'escort' => function ($q) {
                    $q->select('id', 'name');
                }, 'escort.photos' => function ($q) {
                    $q->whereDate(Photo::CREATED_AT, Carbon::today());
                }
            ])
            ->whereHas('escort.photos', function ($q) {
                $q->whereDate(Photo::CREATED_AT, Carbon::today());
            })
            ->get();
    }
}
