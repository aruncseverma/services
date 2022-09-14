<?php
/**
 * escort's photo model repository class
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */

namespace App\Repository;

use App\Models\Folder;
use Illuminate\Support\Collection;

class FolderRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Folder $model
     */
    public function __construct(Folder $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\Folder|null
     */
    public function find($id) : Folder
    {
        return $this->getBuilder()
            ->where($this->getModel()->getKeyName(), $id)
            ->first();
    }

    /**
     *  Fetches all albums by the user
     *
     *  @param int $userId
     *  @return Illuminate\Support\Collection
     */
    public function fetchAllFoldersByUser($userId) : Collection
    {
        return $this->getBuilder()
            ->where('user_id', $userId)
            ->get();
    }

    /**
     *  Fetch albums by type
     *
     *  @param String $type
     *  @param String $userId
     *  @return Illuminate\Support\Collection
     */
    public function fetchFolderByType($type, $userId) : Collection
    {
        return $this->getBuilder()
            ->where('user_id', $userId)
            ->where('type', $type)
            ->get();
    }

    /**
     * Fetches public album
     *
     * @param String $userId
     * @return App\Models\Folder|null
     */
    public function getPublicFolder($userId)
    {
        return $this->getBuilder()
            ->where('user_id', $userId)
            ->where('type', Folder::PUBLIC_FOLDER)
            ->first();
    }

    /**
     * Checks if the user has Public folder
     *
     * @param String $userId
     * @return boolean
     */
    public function hasPublicFolder($userId) : bool
    {
        return $this->getBuilder()
            ->where('user_id', $userId)
            ->where('type', Folder::PUBLIC_FOLDER)
            ->exists();
    }

    /**
     *  updates information of the folder
     *
     *  @param int $id
     *  @param array $details
     *  @return int
     */
    public function updateFolderInfo($id, $details) : int
    {
        return $this->getBuilder()
            ->where('id', $id)
            ->update($details);
    }

    /**
     *  Deletes Folder
     *
     *  @param int $folderId
     *  @return boolean
     */
    public function remove($folderId)
    {
        return $this->getBuilder()
            ->where('id', $folderId)
            ->delete();
    }
}
