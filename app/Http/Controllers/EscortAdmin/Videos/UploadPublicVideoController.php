<?php
/**
 * controller class for uploading public video to the server
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use App\Models\UserVideo;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadPublicVideoController extends Controller
{
    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle(Request $request) : View
    {
        // validates file uploaded
        $this->validateUploadedFile($request);

        // get model of request video
        $video = $this->getModelFromRequest($request);

        if (! is_null($video)) {
            $this->deletePreviousVideo($video);
        }

        // upload file to server (public)
        $path = $this->uploadPublicVideo($request->file('video'));
        $user = $this->getAuthUser();

        if (! empty($path)) {
            // save data to repository
            $videoData = $this->videos->store(
                [
                    'path' => $path,
                    'visibility' => UserVideo::VISIBILITY_PUBLIC,
                ],
                $user,
                null, // no folder
                $video
            );

            $this->addUserActivity(self::ACTIVITY_TYPE, $videoData->getKey(), $video ? 'update_public_video' : 'add_public_video');

            $this->removeEscortFilterCache('with_video');

            return view('EscortAdmin::videos.components.public_videos', [
                'public' => $this->videos->getUserPublicVideos($user),
                'allowedExts' => $this->getAllowedExtensions(),
                'maxPublicVideos' => static::MAX_PUBLIC_PHOTOS
            ]);
        }

        // abort request (means request was not possible due to server error)
        abort(503);
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

    /**
     * delete previous video file from storage
     *
     * @param  App\Models\UserVideo $video
     *
     * @return boolean
     */
    protected function deletePreviousVideo(UserVideo $video) : bool
    {
        return $this->deletePublicVideoFile($video->path);
    }
}
