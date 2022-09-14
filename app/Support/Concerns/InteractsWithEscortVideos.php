<?php
/**
 * usable methods for escorts videos
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

trait InteractsWithEscortVideos
{
    /**
     * get public video storage adapter
     *
     * @return Illuminate\Filesystem\FilesystemAdapter
     */
    public function getPublicVideoStorage() : FilesystemAdapter
    {
        return Storage::disk($this->getPublicVideoStorageName());
    }

    /**
     * get private video storage adapater
     *
     * @return Illuminate\Filesystem\FilesystemAdapter
     */
    public function getPrivateVideoStorage() : FilesystemAdapter
    {
        return Storage::disk($this->getPrivateVideoStorageName());
    }

    /**
     * upload file to public storage of video
     *
     * @param  Illuminate\Http\UploadedFile $file
     *
     * @return string|null
     */
    public function uploadPublicVideo(UploadedFile $file) : ?string
    {
        return $file->store(null, $this->getPublicVideoStorageName());
    }

    /**
     * retrieves public video storage name from config/filesystems
     *
     * @return string
     */
    protected function getPublicVideoStorageName() : string
    {
        return 'public_videos';
    }

    /**
     * retrieves public video storage name from config/filesystems
     *
     * @return string
     */
    protected function getPrivateVideoStorageName() : string
    {
        return 'private_videos';
    }

    /**
     * deletes public video file using path given
     *
     * @param  string $path
     *
     * @return boolean
     */
    protected function deletePublicVideoFile(string $path) : bool
    {
        $storage = $this->getPublicVideoStorage();
        return ($storage->exists($path)) ? $storage->delete($path) : false;
    }

    /**
     * delete private video
     *
     * @param  string $path
     *
     * @return boolean
     */
    protected function deletePrivateVideo(string $path) : bool
    {
        $storage = $this->getPrivateVideoStorage();
        return ($storage->exists($path)) ? $storage->delete($path) : false;
    }

    /**
     * store private video from a given folder path
     *
     * @param  string                       $path
     * @param  Illuminate\Http\UploadedFile $file
     *
     * @return string|null
     */
    protected function uploadPrivateVideo(string $path, UploadedFile $file) : ?string
    {
        return $file->store($path, $this->getPrivateVideoStorageName());
    }
}
