<?php

/**
 * usable methods for interacting with member photos storage
 *
 */

namespace App\Support\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

trait InteractsWithMemberPhotoStorage
{
    /**
     * get photo storage instance for member photo
     *
     * @return Illuminate\Filesystem\FilesystemAdapter
     */
    public function getMemberPhotoStorage(): FilesystemAdapter
    {
        return Storage::disk($this->getMemberPhotoStorageName());
    }

    /**
     * upload member photo name
     *
     * @param  Illuminate\Http\UploadedFile $file
     *
     * @return string|null
     */
    public function uploadMemberPhoto(UploadedFile $file): ?string
    {
        return $file->store(null, $this->getMemberPhotoStorageName());
    }

    /**
     * delete file of member photo from the storage
     *
     * @param  string $path
     *
     * @return boolean
     */
    public function deleteMemberPhoto(string $path): bool
    {
        return $this->getMemberPhotoStorage()->delete($path);
    }

    /**
     * retrieves the photo storage name
     *
     * @return string
     */
    protected function getMemberPhotoStorageName(): string
    {
        return 'member_photos';
    }
}
