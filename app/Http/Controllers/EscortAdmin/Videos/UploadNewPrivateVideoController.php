<?php

namespace App\Http\Controllers\EscortAdmin\Videos;

use App\Models\Escort;
use App\Models\UserVideo;
use App\Support\Concerns\UsesFFMpeg;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UploadNewPrivateVideoController extends Controller
{
    // inherits the ffmpeg functionalities
    use UsesFFMpeg;

    public function handle(Request $request)
    {

        $user = $this->getAuthUser();

        // validates file uploaded
        $this->validateUploadedFile($request);

        // store video in temporary files
        $filename = $request->file('video')->store(null, 'tmp');

        // check folder
        $this->validateFolder($request->input('folder_id'), $user);

        // get model of request video
        $video = $this->getModelFromRequest($request);

        // upload file to server (private)
        $folder = $this->folders->find($request->input('folder_id'));

        $this->init();
        $this->setUploader($user);
        $data = $this->store($filename, 0, $folder->path);

        $videoAttr = [
            'path' => $data['path'],
            'thumbnail' => $data['thumbnail'],
            'visibility' => UserVideo::VISIBILITY_PRIVATE
        ];

        // saves video data
        $videoData = $this->videos->store(
            $videoAttr,
            $user,
            $folder,
            $video
        );

        $posData = [
            'position' => 0,
            'media_id' => $videoData->id,
            'folder_id' => $folder->getKey(),
            'user_id' => $user->getKey(),
            'type' => 'V'
        ];

        // creates a position data
        $this->position->save($posData);

        $this->addUserActivity(self::ACTIVITY_TYPE, $videoData->getKey(), $video ? 'update_public_video' : 'add_public_video');

        return json_encode(['public' => $this->videos->getUserPublicVideos($user)]);
    }

    
    /**
     * validate folder requested
     *
     * @param  integer|null      $id
     * @param  App\Models\Escort $escort
     *
     * @return void
     */
    protected function validateFolder(?int $id, Escort $escort) : void
    {
        $folder = $this->folders->find($id);

        // check folder
        if (! $folder) {
            $this->throwResponse(['message' => __('Folder is not valid')], 404);
        }

        // check folder access
        if ($escort->getKey() != $folder->user->getKey()) {
            $this->throwResponse(['message' => __('Unauthorized folder access')], 403);
        }
    }

    /**
     * get instance of user video model from request
     *
     * @throws Illuminate\Http\HttpResponseException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return App\Models\UserVideo|null
     */
    protected function getModelFromRequest(Request $request) : ?UserVideo
    {
        if ($id = $request->input('id')) {
            $model = $this->videos->find($id);

            // throw http exception
            if (! $model) {
                throw new HttpResponseException(response()->json(['message' => __('Unknown video')], 400));
            }

            return $model;
        }

        return null;
    }
}