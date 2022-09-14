<?php
/**
 * base controller class for videos namespace
 *
 * @abstract
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Videos;

use Illuminate\Http\Request;
use App\Repository\UserVideoRepository;
use App\Repository\UserVideoFolderRepository;
use App\Support\Concerns\InteractsWithEscortVideos;
use App\Http\Controllers\EscortAdmin\Controller as BaseController;
use App\Models\UserActivity;
use App\Support\Concerns\EscortFilterCache;
use App\Repository\MediaPositionRepository;

abstract class Controller extends BaseController
{
    use InteractsWithEscortVideos;
    use EscortFilterCache;

    /**
     * default user activity type
     *
     * @const
     */
    const ACTIVITY_TYPE = UserActivity::VIDEO_TYPE;

    /**
     * max number of public photos
     *
     * @const
     */
    const MAX_PUBLIC_PHOTOS = 4;

    /**
     * create instance
     *
     * @param App\Repository\UserVideoRepository       $videos
     * @param App\Repository\UserVideoFolderRepository $folders
     * @param App\Repository\MediaPositionRepository   $position
     */
    public function __construct(UserVideoRepository $videos, UserVideoFolderRepository $folders, MediaPositionRepository $position)
    {
        $this->position = $position;
        $this->videos = $videos;
        $this->folders = $folders;

        parent::__construct();
    }

    /**
     * validates incoming video file from request
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateUploadedFile(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'video' => [
                    'required',
                    'file',
                    'mimes:' . implode(',', $this->getAllowedExtensions()),
                ]
            ]
        );
    }

    /**
     * get all allowed video extensions
     *
     * @return array
     */
    protected function getAllowedExtensions() : array
    {
        return ['mp4', 'avi', 'flv', 'mov', 'wmv'];
    }
}
