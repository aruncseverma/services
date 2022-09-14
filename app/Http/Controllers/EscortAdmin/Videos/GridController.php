<?php

namespace App\Http\Controllers\EscortAdmin\Videos;

use App\Http\Controllers\EscortAdmin\Videos\Controller;
use App\Support\Concerns\NeedsStorage;
use Illuminate\Contracts\View\View;

class GridController extends Controller
{
    use NeedsStorage;

    /**
     * render view
     *
     * @return View
     */
    public function view() : View
    {
        $this->setTitle(__('Videos'));

        $user = $this->getAuthUser();
        $maxPublicVideos = 4;
        $folders = $this->folders->getUserVideoFolders($user);
        $selectedFolder = null;
        $selectedFolderVideos = null;

        if ($folders->count() > 0) {
            $selectedFolder = $folders->get(0);
            $selectedFolderVideos = $this->position->getAllMediaWithinFolder('V', $selectedFolder->getKey(), $user->getKey());
        }

        $allowedExts = $this->getAllowedExtensions();

        return view('EscortAdmin::videos.grid', [
            'storage' => $this->getStorage(),
            'public' => $this->position->getAllMediaWithinFolder('V', 0, $user->getKey()),
            'maxPublicVideos' => $maxPublicVideos,
            'folders' => $folders,
            'selectedFolder' => $selectedFolder,
            'privateVideos' => $selectedFolderVideos
        ]);
    }
}
