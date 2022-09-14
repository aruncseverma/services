<?php
/**
 * controller class for uploading private videos
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use App\Models\Escort;
use App\Models\UserVideo;
use Illuminate\Http\Request;
use App\Models\UserVideoFolder;
use App\Support\Concerns\IsActionWithinPlan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadPrivateVideoController extends Controller
{
    use IsActionWithinPlan;
    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    public function handle(Request $request) : View
    {
        // validates file uploaded
        $this->validateUploadedFile($request);

        $escort = $this->getAuthUser();

        // check folder
        $this->validateFolder($request->input('folder_id'), $escort);

        // get model of request video
        $video = $this->getModelFromRequest($request);

        if (! is_null($video)) {
            $this->deletePreviousVideo($video);
        }

        // upload file to server (private)
        $folder = $this->folders->find($request->input('folder_id'));
        $path = $this->uploadPrivateVideo($folder->path, $request->file('video'));

        if (! empty($path)) {
            // save data to repository
            $videoData = $this->videos->store(
                [
                    'path' => $path,
                    'visibility' => UserVideo::VISIBILITY_PRIVATE,
                ],
                $escort,
                $folder, // no folder
                $video
            );

            $this->addUserActivity(self::ACTIVITY_TYPE, $videoData->getKey(), $video ? 'update_private_video' : 'add_private_video');

            $this->removeEscortFilterCache('with_video');

            // generate view
            return view('EscortAdmin::videos.components.private_videos', [
                'selectedFolder' => $folder,
                'folders' => $this->folders->getUserVideoFolders($escort),
                'allowedExts' => $this->getAllowedExtensions(),
            ]);
        }

        // abort request (means request was not possible due to server error)
        abort(503);
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
     * throw response imediately
     *
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     *
     * @param  array   $data
     * @param  integer $status
     *
     * @return void
     */
    protected function throwResponse(array $data, int $status) : void
    {
        throw new HttpResponseException(response()->json($data, $status));
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
        return $this->deletePrivateVideo($video->path);
    }
}
