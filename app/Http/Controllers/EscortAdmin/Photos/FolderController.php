<?php
/**
 *  Handles process for escort's folder
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{

    /**
     *  Fetches the details of the Main Folder
     *
     *  @return App\Models\Folder
     */
    public function getMainFolder()
    {
        return $this->folderRepository->fetchFolderByType(Folder::PUBLIC_FOLDER, $this->getAuthUser()->getKey())[0];
    }

    /**
     *  Fetches all folders both Public and Private
     *
     *  @return Illuminate\Support\Collection
     */
    public function getAllFolders() : Collection
    {
        return $this->folderRepository->fetchAllFoldersByUser($this->getAuthUser()->getKey());
    }

    /**
     *  Fetches all Private folders
     *
     *  @return Illuminate\Support\Collection
     */
    public function getAllPrivateFolders() : Collection
    {
        return $this->folderRepository->fetchFolderByType(Folder::PRIVATE_FOLDER, $this->getAuthUser()->getKey());
    }

    /**
     *  Fetches data and photos of a specific folder
     *
     *  @param String folder_id
     *  @return array $result
     */
    public function getFolderInfo($folderId)
    {

        $result = [
            'status' => [
                'code' => 0,
                'message' => "Couldn't fetch folder information."
            ]
        ];

        $folderInfo = $this->folderRepository->find($folderId);
        
        if ($folderInfo) {
            $result['data'] = $folderInfo->toArray();
            $photoList = $this->photoRepository->fetchPhotosByFolder($folderId);

            if ($photoList) {
                $list = [];
                foreach ($photoList->toArray() as $val) {
                    $val['path'] = Storage::url($val['path']);
                    array_push($list, $val);
                }

                $result['data']['photos'] = $list;
            }

            $result['status']['code'] = 1;
            $result['status']['message'] = "Success";
        }

        return $result;
    }
}
