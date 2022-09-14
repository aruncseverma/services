<?php
/**
 * Handles photo deletion
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use Illuminate\Http\Request;
use App\Repository\PhotoRepository;
use Illuminate\Support\Facades\Storage;

class DeletePhotoController extends Controller
{

    /**
     *  Handles photo deletion
     *
     *  @param Request $request
     *  @return int $success
     */
    public function handle(Request $request)
    {
        $result = 0;

        $imageId = $request->input('image_id');
        
        if ($imageId != null) {
            $data = $this->photoRepository->find($imageId);
            $result = $this->photoRepository->remove($imageId);

            if ($result) {
                Storage::delete($data->path);
                $this->addUserActivity(self::ACTIVITY_TYPE, $imageId, 'delete_photo');
            }
        }

        return $result;
    }
}
