<?php
/**
 * controller class for managing escort videos
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * render view
     *
     * @return View
     */
    public function view() : View
    {
        $this->setTitle(__('Videos'));

        $user = $this->getAuthUser();
        $public = $this->videos->getUserPublicVideos($user);
        $folders = $this->folders->getUserVideoFolders($user);
        $selectedFolder = $folders->get(0);
        $allowedExts = $this->getAllowedExtensions();

        return view('EscortAdmin::videos.manage', [
            'public' => $public,
            'folders' => $folders,
            'allowedExts' => $allowedExts,
            'selectedFolder' => $selectedFolder,
            'maxPublicVideos' => static::MAX_PUBLIC_PHOTOS
        ]);
    }
}
