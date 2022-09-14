<?php
/**
 *  Handles Uploading of escort's photos
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repository\Concerns\InteractsWithEscortAssets;
use App\Support\Concerns\IsActionWithinPlan;

class UploadController extends Controller
{

    use InteractsWithEscortAssets, IsActionWithinPlan;

    /**
     *  Handles image upload
     *
     *  @param Request $request
     *  @return json $image_url
     */
    public function handle(Request $request)
    {

        if (!$this->isImageUploadLimitReached($this->getAuthUser())) {
            $escortFolder = '';

            if ($request->post('destination_folder') == 'M') {
                $escortFolder = $this->getPublicFolder($this->folderRepository, $this->getAuthUser()->getKey());
            } else {
                $escortFolder = $this->folderRepository->find($request->post('destination_folder'));
            }

            // get the filename from the request
            $filename = $request->post('filename');

            // rename the folder
            if (strpos($filename, 'main') === false) {
                $timestamp = strtotime(date('Y-m-d H:i:s'));
                $filename = $this->getAuthUser()->getKey() . '-image-uploaded-' . $timestamp;
            }

            // check if there's already a primary photo
            $primary = $this->photoRepository->fetchPrimaryPhoto($this->getAuthUser()->getKey());

            // process the cropped image data
            $filename = $filename . '.jpg';
            $img = $request->post('file');
            $imgData = getimagesize($img);

            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            // generate a path
            $filePath = $escortFolder->path .'/'. $filename;

            // create the file into the destination
            Storage::put($filePath, $data);

            // Start uploading the info to the database
            $photo              = new Photo();
            $photo->setAttribute('user_id', $this->getAuthUser()->getKey());
            $photo->setAttribute('folder_id', $escortFolder->id);
            $photo->setAttribute('is_primary', ($primary) ? 0 : 1);
            $photo->type        = ($request->post('destination_folder') == 'M') ? 'M' : 'P';
            $photo->path        = $filePath;
            $photo->data = [
                'width' => $imgData[0] ?? 0,
                'height' => $imgData[1] ?? 0,
            ];

            // SAVE!
            $photo->save();

            $this->addUserActivity(self::ACTIVITY_TYPE, $photo->getKey(), 'add_photo');

            $disk = $this->extractDiskFromPath($filePath);

            return json_encode([
                'result' => true,
                'url' => Storage::disk($disk)->url($filePath), 
                'id' => $photo->id
            ]);
        } else {
            return json_encode([
                'result' => false,
                'error' => __('Upload limit reached.')
            ]);
        }
    }
}
