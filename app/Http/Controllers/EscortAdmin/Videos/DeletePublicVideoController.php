<?php
/**
 * controller class for delete a public video
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeletePublicVideoController extends Controller
{
    /**
     * handle incoming request
     *
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle(Request $request) : View
    {
        $id = $request->input('id');
        $video = $this->videos->find($id);
        $user = $this->getAuthUser();

        // checks video existency
        if (! $video) {
            return $this->throwJsonResponse(response()->json(['message' => __('Unknown Video')], 400));
        }

        // checks user ownership
        if ($video->user->getKey() !== $user->getKey()) {
            $this->throwJsonResponse(response()->json(['message' => __('Unauthorized Action')], 401));
        }

        // delete video file first then delete the record
        if ($this->deletePublicVideoFile($video->path)) {
            $this->videos->delete($video->getKey());

            $this->addUserActivity(self::ACTIVITY_TYPE, $video->getKey(), 'delete_public_video');

            $this->removeEscortFilterCache('with_video');
            // delete media position
            $params = [
                'media_id' => $id,
                'folder_id' => 0,
                'user_id' => $user->getKey()
            ];

            $this->position->removeMediaPositionData($params);

            return view('EscortAdmin::videos.components.public_videos', [
                'public' => $this->videos->getUserPublicVideos($user),
                'allowedExts' => $this->getAllowedExtensions(),
                'maxPublicVideos' => static::MAX_PUBLIC_PHOTOS
            ]);
        }

        return $this->throwJsonResponse(
            response()->json(['message' => __('Video was unable to delete. Please try again later')], 503)
        );
    }

    /**
     * throws created json response instance
     *
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     *
     * @param Illuminate\Http\JsonResponse $response
     *
     * @return void
     */
    protected function throwJsonResponse(JsonResponse $response) : void
    {
        throw new HttpResponseException($response);
    }
}
