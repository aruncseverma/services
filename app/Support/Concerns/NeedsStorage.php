<?php
/**
 * usable methods for classes which needs application storage logic
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Contracts\Filesystem\Filesystem;

trait NeedsStorage
{
    /**
     * get storage manager interface
     *
     * @return Illuminate\Filesystem\FilesystemManager
     */
    public function getStorage() : FilesystemManager
    {
        return app('filesystem');
    }

    /**
     * get disk name for mugshots
     *
     * @return string
     */
    protected function getDiskNameForMugShots() : string
    {
        return 'mug_shots';
    }

    /**
     * get disk name for private photo id
     *
     * @return string
     */
    protected function getDiskNameForPrivatePhotoId() : string
    {
        return 'private_photo_id';
    }

    /**
     * delete a file using the path and the storage for it
     *
     * @param  string                                     $path
     * @param  Illuminate\Contracts\Filesystem\Filesystem $fs
     * @return boolean
     */
    protected function deleteFile(string $path, Filesystem $fs) : bool
    {
        return $fs->delete($path);
    }
}
