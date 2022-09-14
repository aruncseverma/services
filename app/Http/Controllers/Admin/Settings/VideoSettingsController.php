<?php
/**
 * controller class for video settings information
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Admin\Settings;

use App\Support\Concerns\NeedsStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class VideoSettingsController extends Controller
{
    use NeedsStorage;

    /**
     * settings default type
     *
     * @const
     */
    const DEFAULT_GROUP = 'video';

    /**
     * view video settings form
     *
     * @return View
     */
    public function index() : View
    {
        $this->setTitle(__('Video Settings'));

        $settings = self::DEFAULT_GROUP;

        $config = config($settings);
        $watermark = "https://via.placeholder.com/360x240.png?text=Placeholder";

        if (isset($config['watermark_url'])) {
            $storage = $this->getStorage()->disk('admin');
            $path = $config['watermark_url'];
            $img = $storage->get($path);
            $mime = $storage->mimeType($path);

            $watermark = [
                'mime' => $mime,
                'img' => $img
            ];
        }

        return view('Admin::settings.video', [
            'group' => $settings,
            'watermark' => $watermark
        ]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function attachMiddleware() : void
    {
        $this->middleware('can:general_settings.manage');
    }

    /**
     * uploads the image and returns the path
     *
     * @param Request $request
     * @return json
     */
    public function uploadFile(Request $request)
    {
        $this->validateUpload($request);

        return json_encode([
            'success' => true,
            'path' => $this->storeUploadedFile($request->file('video_watermark'))
        ]);
    }

    /**
     * validates uploaded file
     *
     * @param Request $request
     * @return void
     */
    public function validateUpload(Request $request)
    {
        $this->validate(
            $request,
            [
                'video_watermark' => 'mimes:jpeg,bmp,png,jpg,pdf'
            ]
        );
    }

    /**
     * store uploaded payment invoice
     *
     * @param Illuminate\Http\UploadedFile $file
     * @return string|false
     */
    protected function storeUploadedFile(UploadedFile $file)
    {
        $options['visibility'] = 'public';
        return $file->store(null, 'admin');
    }
}
