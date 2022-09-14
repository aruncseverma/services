<?php
/**
 * controller class for rendering  user video
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Common\Videos;

use App\Models\UserVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\UserVideoRepository;
use App\Support\Concerns\InteractsWithEscortVideos;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RenderVideoController extends Controller
{
    use InteractsWithEscortVideos;

    /**
     * user videos repository instance
     *
     * @var App\Repository\UserVideoRepository
     */
    protected $videos;

    /**
     * create instance
     *
     * @param App\Repository\UserVideoRepository $videos
     */
    public function __construct(UserVideoRepository $videos)
    {
        $this->videos = $videos;
    }

    /**
     * renders video
     *
     * @param  App\Models\UserVideo $video
     *
     * @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(Request $request) : BinaryFileResponse
    {
        $id = $request->get('id');
        $video = $this->videos->find($id);
        $user = $this->getAuthUser();
        $admin = auth()->guard('admin')->user();
        $escort = auth()->guard('escort_admin')->user();

        if (empty($video)) {
            abort(404);
        }

        if ($video->isPrivate()) {
            // checks if current video is viewed as private
            if (empty($user) && empty($admin) && empty($escort)) {
                abort(404);
            } elseif (! empty($escort) && $video->user->getKey() != $escort->getKey()) {
                abort(404);
            }
        }

        $path = $video->path;
        $storage = ($video->isPrivate())
            ? $this->getPrivateVideoStorage()
            : $this->getPublicVideoStorage();

        return ($storage->exists($path))
            ? response()->file($storage->path($path))
            : abort(404);
    }
}
