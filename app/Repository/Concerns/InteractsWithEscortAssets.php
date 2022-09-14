<?php
/**
 * usable methods for controllers which deals with escort's
 * assets folder
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Repository\Concerns;

use App\Models\Folder;
use Illuminate\Support\Collection;
use App\Repository\FolderRepository;
use Illuminate\Support\Facades\Storage;

trait InteractsWithEscortAssets
{

    /**
     *  Creates the main folder container for the escort
     *
     *  @param App\Models\Folder $folder
     *  @return bool is_created
     */
    public function createMainFolder(Folder $folder) : bool
    {
        if (! Storage::exists($folder->path)) {
            if ($folder->save()) {
                return Storage::makeDirectory($folder->path, 0755, true, false);
            }
        }

        return true;
    }

    /**
     * Undocumented function
     *
     * @param App\Repository\FolderRepository $repository
     * @param String $userId
     * @return Illuminate\Support\Collection
     */
    public function getPrivateFolders(FolderRepository $repository, $userId) : Collection
    {
        return $repository->fetchFolderByType(Folder::PRIVATE_FOLDER, $userId);
    }

    /**
     * Fetches the information of the public folder
     *
     * @param App\Repository\FolderRepository $repository
     * @param String $userId
     * @return App\Models\Folder
     */
    public function getPublicFolder(FolderRepository $repository, $userId)
    {
        return $repository->getPublicFolder($userId);
    }

    /**
     * extracts disk from the path given
     *
     * @param  string|null $path
     *
     * @return string|null
     */
    protected function extractDiskFromPath(?string $path) : ?string
    {
        // return null if value is empty
        if (empty($path)) {
            return null;
        }

        // normalize path
        $path = ltrim($path);

        return substr($path, 0, strpos($path, '/'));
    }
}
