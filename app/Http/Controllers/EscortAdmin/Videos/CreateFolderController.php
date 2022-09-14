<?php
/**
 * controller class for creating a private folder for the current escort
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateFolderController extends Controller
{
    /**
     * default folder name for the newly created one
     *
     * @const
     */
    const DEFAULT_FOLDER_NAME = 'New Folder';

    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle(Request $request) : View
    {
        $path = $this->getNewFolderName();
        $storage = $this->getPrivateVideoStorage();

        // create the folder (recursively)
        if (! $storage->makeDirectory($path, 0755, true)) {
            throw new HttpResponseException(response()->json(['message' => __('Unable to create a new folder')], 503));
        }

        // store create folder to the repository
        $folder = $this->folders->store(
            [
                'path' => $path,
            ],
            $escort = $this->getAuthUser()
        );

        // render view
        return view('EscortAdmin::videos.components.private_videos', [
            'folders' => $this->folders->getUserVideoFolders($escort),
            'selectedFolder' => $folder,
            'allowedExts' => $this->getAllowedExtensions(),
        ]);
    }

    /**
     * get default folder name
     *
     * @return string
     */
    protected function getDefaultFolderName() : string
    {
        return static::DEFAULT_FOLDER_NAME;
    }

    /**
     * get new folder name that is available from the storage
     *
     * @return string
     */
    protected function getNewFolderName() : string
    {
        $escort = $this->getAuthUser();
        $exists = true;
        $counter = 0;
        $path = sprintf('%d/%s', $escort->getKey(), $this->getDefaultFolderName());

        // check if current folder name is exists in the storage
        // if exists then try to prefix with the counter available
        // if still exists when counter continue loop until exists turns false
        while ($exists) {
            if ($counter > 0) {
                $path = $this->createUniqueFolderName($path, $counter);
            }
            if ($exists = $this->getPrivateVideoStorage()->exists($path)) {
                ++$counter;
            }
        }

        return $path;
    }

    /**
     * creates a unique folder name based on given counter count
     *
     * @param  string $path
     * @param  integer $counter
     *
     * @return string
     */
    protected function createUniqueFolderName(string $path, int $counter) : string
    {
        if (preg_match('/\([\d+]\)/', $path)) {
            return preg_replace('/\([\d+]\)/', "({$counter})", $path);
        }
        return sprintf('%s (%d)', $path, $counter);
    }
}
