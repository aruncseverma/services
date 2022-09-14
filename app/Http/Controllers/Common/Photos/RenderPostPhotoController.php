<?php

namespace App\Http\Controllers\Common\Photos;

use App\Models\PostPhoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Support\Concerns\InteractsWithPostPhotoStorage;

class RenderPostPhotoController extends Controller
{
    use InteractsWithPostPhotoStorage;

    /**
     * application filesystem manager
     *
     * @var Illuminate\Filesystem\FilesystemManager
     */
    protected $fsm;

    /**
     * create instance
     *
     * @param Illuminate\Filesystem\FilesystemManager $fsm
     */
    public function __construct(FilesystemManager $fsm)
    {
        $this->fsm = $fsm;
    }

    /**
     * handles rendering function
     *
     * @param  App\Models\PostPhoto        $photo
     * @param  string                  $path
     * @param  Illuminate\Http\Request $request
     *
     * @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function render(PostPhoto $photo, string $path, Request $request): BinaryFileResponse
    {
        // path does not appear to be the same
        if (basename($path) !== basename($photo->path)) {
            abort(404);
        }

        $storage = $this->getPostPhotoStorageName();

        // get photo storage
        if ($storage) {
            $storage = $this->fsm->disk($storage);
        } else {
            $storage = $this->fsm->disk();
        }

        // render file
        return $storage->exists($photo->path)
            ? response()->file($storage->path($photo->path))
            : abort(404);
    }
}
