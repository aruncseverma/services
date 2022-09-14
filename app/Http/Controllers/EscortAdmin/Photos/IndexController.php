<?php
/**
 * escort photos index controller
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Photos;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Repository\Concerns\InteractsWithEscortAssets;
use App\Http\Controllers\EscortAdmin\Photos\CreateFolderController;

class IndexController extends Controller
{
    use InteractsWithEscortAssets;

     /**
     * Render escort photos form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        $this->setTitle('Manage Photos');
        $main = $this->checkIfHasMainFolder();

        return view('EscortAdmin::photos.manage', [
            'user'      => $this->getAuthUser(),
            'photos'    => $this->fetchAllPhotos($main == null ? 0 : $main->id),
            'folders'   => $this->folderRepository->fetchFolderByType(Folder::PRIVATE_FOLDER, $this->getAuthUser()->getKey())
        ]);
    }

    /**
     *  Checks if there is a main folder for this escort
     *
     *  @return App\Models\Folder|null
     */
    protected function checkIfHasMainFolder() : Folder
    {
        $escortFolder = $this->folderRepository->hasPublicFolder($this->getAuthUser()->getKey());

        if (! $escortFolder) {
            $escortFolderPath = 'public/escorts/photos/' . $this->getAuthUser()->getKey() . '/main';

            $folder = new Folder();
            $folder->setAttribute('user_id', $this->getAuthUser()->getKey());
            $folder->name = 'Main';
            $folder->type = 'M';
            $folder->path = $escortFolderPath;

            $this->createMainFolder($folder);
        }

        return $this->getPublicFolder($this->folderRepository, $this->getAuthUser()->getKey());
    }

    /**
     *  Fetches all images within the specified folder id
     *
     *  @param String $folderId
     *  @return array $images
     */
    protected function fetchAllPhotos($folderId = 0) : array
    {
        $photoList = [];
        $photos = [];

        $photoList = $this->photoRepository->fetchPhotosByFolder($folderId);

        if (count($photoList) > 0) {
            foreach ($photoList as $val) {
                $filePath = $val['path'];
                $filename = basename($filePath);

                $photos[$filename] = [
                    'id'        => $val['id'],
                    'url'       => Storage::disk($this->extractDiskFromPath($filePath))->url($filePath),
                    'primary'   => $val['is_primary']
                ];
            }
        }

        return $photos;
    }
}
