<?php
/**
 * handle switching of folder and retrieves the current folder information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;

class SwitchFolderController extends Controller
{
    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request
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

        // generate view
        return view('EscortAdmin::videos.components.private_videos', [
            'selectedFolder' => $folder,
            'folders' => $this->folders->getUserVideoFolders($escort),
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
}
