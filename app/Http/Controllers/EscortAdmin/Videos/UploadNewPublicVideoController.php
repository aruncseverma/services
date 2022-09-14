<?php

namespace App\Http\Controllers\EscortAdmin\Videos;

use App\Models\UserVideo;
use App\Support\Concerns\UsesFFMpeg;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UploadNewPublicVideoController extends Controller
{
    // inherits the ffmpeg functionalities
    use UsesFFMpeg;

    public function handle(Request $request)
    {
        // validates file uploaded
        $this->validateUploadedFile($request);

        // store video in temporary files
        $filename = $request->file('video')->store(null, 'tmp');

        // get model of request video
        $video = $this->getModelFromRequest($request);

        $this->init();
        $this->setUploader($this->getAuthUser());
        $data = $this->store($filename, 1);

        $user = $this->getAuthUser();

        $videoAttr = [
            'path' => $data['path'],
            'thumbnail' => $data['thumbnail'],
            'visibility' => UserVideo::VISIBILITY_PUBLIC
        ];

        // saves video data
        $videoData = $this->videos->store(
            $videoAttr,
            $user,
            null,
            $video
        );

        $posData = [
            'position' => 0,
            'media_id' => $videoData->id,
            'folder_id' => 0,
            'user_id' => $user->getKey(),
            'type' => 'V'
        ];

        // creates a position data
        $this->position->save($posData);

        $this->addUserActivity(self::ACTIVITY_TYPE, $videoData->getKey(), $video ? 'update_public_video' : 'add_public_video');

        return json_encode(['public' => $this->videos->getUserPublicVideos($user)]);
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
