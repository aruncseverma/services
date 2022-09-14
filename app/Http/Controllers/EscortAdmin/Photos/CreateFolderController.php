<?php
/**
 *  Handles folder creation
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repository\FolderRepository;

class CreateFolderController extends Controller
{
    /**
     * Handles folder creation
     *
     * @param Illuminate\Http\Request $request
     * @return array $response
     */
    public function handle(Request $request) : array
    {
        // Set default response when error occured
        $response = [
            'status' => [
                'code' => 0,
                'message' => 'Could not create folder'
            ]
        ];

        // Initialize basic information for folder
        $defaultFolderName = 'New Folder';
        $path = "private/escorts/photos/" . $this->getAuthUser()->getKey();

        // Start data storing
        $folders            = new Folder();
        $folders->setAttribute('user_id', $this->getAuthUser()->getKey());
        $folders->name      = $defaultFolderName;
        $folders->type      = 'P';
        $folders->path      = $path;

        // Save the data!
        $folders->save();

        $folderName = md5($folders->id . $this->getAuthUser()->email);
        Storage::makeDirectory("{$path}/{$folderName}", 0755, true, false);

        // Update the created folder with url path
        $update = $this->folderRepository->updateFolderInfo($folders->id, ['path'  => "{$path}/{$folderName}"]);
        
        if ($update && Storage::exists("$path/$folderName")) {
            $response['status']['code'] = 1;
            $response['status']['message'] = 'Success';
    
            $folderInfo = [
                'folder_id'     => $folders->id,
                'folder_name'   => $defaultFolderName
            ];
    
            $response['data'] = $folderInfo;
        } else {
            $this->folder->remove($folder->id);
            Storage::deleteDirectory("{$path}/{$folderName}");
        }
        
        return $response;
    }
}
