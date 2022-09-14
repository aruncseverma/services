<?php
/**
 *  Handles any type of deletion for folder
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteFolderController extends Controller
{

    /**
     *  Handles private folder deletion
     *
     *  @param String $folderId
     *  @return int $success
     */
    public function handle($folderId)
    {
        if ($folderId != 0) {
            $folderInformation = $this->folderRepository->find($folderId);
            $deletion = $this->folderRepository->remove($folderInformation->id);

            if ($deletion) {
                return Storage::deleteDirectory($folderInformation->path) ? 1 : 0;
            }
        }

        return 0;
    }
}
