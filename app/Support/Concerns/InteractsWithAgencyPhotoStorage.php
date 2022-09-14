<?php
/**
 * usable methods for interacting with agency photos storage
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

trait InteractsWithAgencyPhotoStorage
{
    /**
     * get photo storage instance for agency photo
     *
     * @return Illuminate\Filesystem\FilesystemAdapter
     */
    public function getAgencyPhotoStorage() : FilesystemAdapter
    {
        return Storage::disk($this->getAgencyPhotoStorageName());
    }

    /**
     * upload agency photo name
     *
     * @param  Illuminate\Http\UploadedFile $file
     *
     * @return string|null
     */
    public function uploadAgencyPhoto(UploadedFile $file) : ?string
    {
        return $file->store(null, $this->getAgencyPhotoStorageName());
    }

    /**
     * delete file of agency photo from the storage
     *
     * @param  string $path
     *
     * @return boolean
     */
    public function deleteAgencyPhoto(string $path) : bool
    {
        return $this->getAgencyPhotoStorage()->delete($path);
    }

    /**
     * retrieves the photo storage name
     *
     * @return string
     */
    protected function getAgencyPhotoStorageName() : string
    {
        return 'agency_photos';
    }
}
