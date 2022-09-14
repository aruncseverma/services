<?php
/**
 * controller class for deleting a folder for current user
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use Illuminate\Http\Request;
use App\Models\UserVideoFolder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteFolderController extends Controller
{
    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle(Request $request) : View
    {
        $folder = $this->folders->find($request->input('id'));
        $escort = $this->getAuthUser();

        // not found
        if (! $folder) {
            $this->throwResponse(['message' => __('Video folder not found')], 404);
        }

        // forbidden
        if ($folder->user->getKey() !== $escort->getKey()) {
            $this->throwResponse(['message' => __('Unauthorized folder access')], 403);
        }

        // renames current folder
        $this->deleteFolder($folder);

        // generate view
        return view('EscortAdmin::videos.components.private_videos', [
            'folders' => $folders = $this->folders->getUserVideoFolders($escort),
            'selectedFolder' => $folders->get(0),
            'allowedExts' => $this->getAllowedExtensions(),
        ]);
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
     * deletes a folder and its content and delete it to the repository
     *
     * @param  App\Models\UserVideoFolder $folder
     *
     * @return boolean
     */
    protected function deleteFolder(UserVideoFolder $folder) : bool
    {
        // try to delete first in the local storage then delete the repository
        $storage = $this->getPrivateVideoStorage();

        // delete the folder
        if ($storage->deleteDirectory($folder->path)) {
            // delete the video in this folder
            foreach ($folder->videos as $video) {
                $this->videos->delete($video->getKey());
            }
            // delete the folder
            $this->folders->delete($folder->getKey());

            return true;
        }

        return false;
    }
}
