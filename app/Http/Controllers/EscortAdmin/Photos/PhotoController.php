<?php
/**
 *  Handles Photo fetching and anything related
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    
    /**
     *  Get all photos according to folder id
     *
     *  @param int $folderId
     *  @return array $photos
     */
    public function get($folderId) : array
    {

        if ($folderId == 0) {
            $folderInformation = $this->folderRepository->getMainFolder();

            if ($folderInformation) {
                $folderId = $folderInformation->id;
            }
        }

        $photos = $this->photoRepository->find($folderId);
            
        if ($photos) {
            return $photos->toArray();
        }

        return [];
    }
}
