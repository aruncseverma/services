<?php

/**
 * usable methods for interacting with post photos storage
 *
 */

namespace App\Support\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

trait InteractsWithPostPhotoStorage
{
    /**
     * get photo storage instance for post photo
     *
     * @return Illuminate\Filesystem\FilesystemAdapter
     */
    public function getPostPhotoStorage(): FilesystemAdapter
    {
        return Storage::disk($this->getPostPhotoStorageName());
    }

    /**
     * upload post photo
     *
     * @param  Illuminate\Http\UploadedFile $file
     *
     * @return string|null
     */
    public function uploadPostPhoto(UploadedFile $file): ?string
    {
        return $file->store(null, $this->getPostPhotoStorageName());
    }

    /**
     * delete file of post photo from the storage
     *
     * @param  string $path
     *
     * @return boolean
     */
    public function deletePostPhoto(string $path): bool
    {
        return $this->getPostPhotoStorage()->delete($path);
    }

    /**
     * retrieves the photo storage name
     *
     * @return string
     */
    protected function getPostPhotoStorageName(): string
    {
        return 'post_photos';
    }
}
