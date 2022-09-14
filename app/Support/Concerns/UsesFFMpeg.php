<?php
/**
 * processes the uploaded video of the user
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Support\Concerns;

use App\Events\EscortAdmin\File\UploadComplete;
use App\Events\EscortAdmin\File\UploadFailed;
use App\Events\EscortAdmin\File\UploadProgress;
use App\Models\User;
use App\Repository\SettingRepository;
use Exception;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

trait UsesFFMpeg {

    use NeedsStorage;

    /**
     * sets the settings group for repository
     *
     * @var string
     */
    protected $group = 'video';
    
    /**
     * generated name for the file and thumbnail
     *
     * @var string
     */
    protected $generatedName = '';

    /**
     * initialize function
     *
     * @return void
     */
    public function init()
    {
        $this->repository = app(SettingRepository::class);
        $this->configs = config($this->group);
    }

    /**
     * processes the video to pre-set configurations
     * in the admin page
     *
     * @param String $file
     * @param boolean $isPublic
     * @return void
     */
    public function store($file, $isPublic = true, $path = null)
    {
        $folder = 'public_videos';

        $fileFormat = $this->configs['format'];
        $fileName = uniqid($this->user->getKey() . strtotime(now()));
        $videoName = $fileName . '.' . $fileFormat;
        $thumbNailName = $fileName . '.jpg';
        $this->type = 'public';

        if (!$isPublic) {
            $folder = 'private_videos';
            $this->type = 'private';
        }

        $presetWidth = isset($this->configs['quality']) ?  $this->configs['quality'] : 360;
        $dimensions = $this->getVideoDimensions($file);

        $aspectRatio = ($dimensions->getWidth() / $dimensions->getHeight());
        $newHeight = intVal($presetWidth / $aspectRatio);

        $newHeight = ($newHeight % 2 != 0) ? $newHeight + 1 : $newHeight;

        $this->generateThumbnail($file, $fileName, $isPublic);

        try {
            FFMpeg::fromDisk('tmp')
                ->open($file)
                ->addWatermark(function(WatermarkFactory $watermark) {
                    $watermark->fromDisk('admin')
                        ->open($this->configs['watermark_url'])
                        ->right(50)
                        ->bottom(50);
                })
                ->export()
                ->onProgress(function ($percentage, $remaining, $rate) {
                    event(new UploadProgress($this->user->getKey(), $percentage, $this->type));
                })
                ->resize($presetWidth, ceil($newHeight))
                ->toDisk($folder)
                ->inFormat(new X264('libmp3lame', 'libx264'))
                ->save($videoName);

            event(new UploadComplete($this->user->getKey(), $this->type));
            Storage::disk('tmp')->delete($file);
            FFMpeg::cleanupTemporaryFiles();

            return [
                'path' => $videoName,
                'thumbnail' => $thumbNailName
            ];

        } catch (Exception $e) {

            Storage::disk('tmp')->delete($file);
            event(new UploadFailed($this->user->getKey(), $e->getMessage()));
        }
    }

    /**
     * sets the uploader user
     *
     * @param User $user
     * @return void
     */
    public function setUploader(User $user)
    {
        $this->user = $user;
    }

    /**
     * generates a thumbnail from the middle of the video
     *
     * @param String $file
     * @param String $fileName
     * @param boolean $isPublic
     * @return void
     */
    public function generateThumbnail($file, $fileName, $isPublic = true)
    {
        $thumbnailName = $fileName . '.jpg';

        $folder = 'public_thumbnail';

        if (!$isPublic) {
            $folder = 'private_thumbnails';
        }

        $middle = floor((int) $this->getDuration($file) / 2);

        FFMpeg::fromDisk('tmp')
            ->open($file)
            ->getFrameFromSeconds($middle)
            ->export()
            ->toDisk($folder)
            ->save($thumbnailName);
    }

    /**
     * probes the uploaded video for its dimensions
     *
     * @param String $file
     * @return Dimensions
     */
    public function getVideoDimensions($file)
    {
        return FFMpeg::fromDisk('tmp')
            ->open($file)
            ->getVideoStream()
            ->getDimensions();
    }

    /**
     * probes the uploaded video for its duration
     *
     * @param String $file
     * @return Long
     */
    public function getDuration($file)
    {
        return FFMpeg::fromDisk('tmp')
            ->open($file)
            ->getDurationInSeconds();
    }
}