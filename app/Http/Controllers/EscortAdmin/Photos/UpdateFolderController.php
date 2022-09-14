<?php
/**
 *  Handles any folder/album manipulation for Escorts
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Repository\FolderRepository;

class UpdateFolderController extends Controller
{

    /**
     *  Handles folder/album modification
     *
     *  @param Illuminate\Http\Request $request
     *  @return boolean $result
     */
    public function handle(Request $request)
    {
        $result = false;

        if ($request->post('folder_id') != null && $request->post('new_name') != null) {
            $result = $this->folderRepository->updateFolderInfo($request->post('folder_id'), ['name' => $request->post('new_name')]);
        }

        return ($result);
    }
}
