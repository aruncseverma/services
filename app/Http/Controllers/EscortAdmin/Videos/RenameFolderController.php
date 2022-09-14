<?php
/**
 * controller class for renaming the current folder name
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use Illuminate\Http\Request;
use App\Models\UserVideoFolder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;

class RenameFolderController extends Controller
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
        $this->validate(
            $request,
            [
                'folder_name' => 'required',
            ]
        );

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
        $this->renameFolder($request->input('folder_name'), $folder);

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

    /**
     * renames the current folder and moves it contents to the new folder
     *
     * @param  string                     $name
     * @param  App\Models\UserVideoFolder $folder
     *
     * @return App\Models\UserVideoFolder
     */
    protected function renameFolder(string $name, UserVideoFolder $folder) : UserVideoFolder
    {
        // generate path
        $newPath = sprintf('%d/%s', $folder->user->getKey(), $name);
        $storage = $this->getPrivateVideoStorage();

        // rename / move contents to the new path
        if (! $storage->exists($newPath)) {
            // checks if move was success then update repository
            if ($storage->move($folder->path, $newPath)) {
                $folder = $this->folders->save(
                    [
                        'path' => $newPath,
                    ],
                    $folder
                );
            }
        }

        // rename the previous path
        return $folder;
    }
}
