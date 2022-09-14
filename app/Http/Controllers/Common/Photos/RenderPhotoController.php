<?php
/**
 * controller class for rendering photos from storage
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Common\Photos;

use App\Models\Photo;
use App\Models\Agency;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Repository\PhotoRepository;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Support\Concerns\InteractsWithAgencyPhotoStorage;
use App\Support\Concerns\InteractsWithMemberPhotoStorage;

class RenderPhotoController extends Controller
{
    use InteractsWithAgencyPhotoStorage;
    use InteractsWithMemberPhotoStorage;

    /**
     * application filesystem manager
     *
     * @var Illuminate\Filesystem\FilesystemManager
     */
    protected $fsm;

    /**
     * create instance
     *
     * @param App\Repository\PhotoRepository          $photos
     * @param Illuminate\Filesystem\FilesystemManager $fsm
     */
    public function __construct(FilesystemManager $fsm)
    {
        $this->fsm = $fsm;
    }

    /**
     * handles rendering function
     *
     * @param  App\Models\Photo        $photo
     * @param  string                  $path
     * @param  Illuminate\Http\Request $request
     *
     * @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function render(Photo $photo, string $path, Request $request) : BinaryFileResponse
    {
        // path does not appear to be the same
        if (basename($path) !== basename($photo->path)) {
            abort(404);
        }

        $storage = $this->getStorage($photo);

        // get photo storage
        if ($storage) {
            $storage = $this->fsm->disk($storage);
        } else {
            $storage = $this->fsm->disk();
        }

        $path = $photo->path;

        // appends folder path
        if (! is_null($photo->folder)) {
            $folder = $photo->folder;
            $path = sprintf('%s/%s', $folder->path, basename($path));
        }

        // render file
        return $storage->exists($photo->path)
            ? response()->file($storage->path($photo->path))
            : abort(404);
    }

    /**
     * get storage name based on photo
     *
     * @param  App\Models\Photo $photo
     *
     * @return string
     */
    protected function getStorage(Photo $photo) : ?string
    {
        $storage = null;

        // agency photo storage
        if ($photo->user->type == Agency::USER_TYPE) {
            $storage = $this->getAgencyPhotoStorageName();
        } else if ($photo->user->type == Member::USER_TYPE) {
            $storage = $this->getMemberPhotoStorageName();
        }

        return $storage;
    }
}
