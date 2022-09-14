<?php
/**
 * handles positioning of media files
 * of escorts in escort admin page
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Repository;

use App\Models\MediaPosition;

class MediaPositionRepository extends Repository
{

    public function __construct(MediaPosition $model)
    {
        $this->bootEloquentRepository($model);
    }

    public function rearrangeMedia(array $arrangement = [], $type = 'P', $userId, $folder, $model)
    {
        if ($model == null) {
            $model = $this->getModel();
        } 

        for($i = 0; $i < count($arrangement); $i++) {
            $attrib = [
                'media_id' => $arrangement[$i],
                'user_id' => $userId,
                'type' => $type,
                'position' => $i,
                'folder_id' => $folder
            ];

            $existing = $this->getFilePosition($attrib, $model);

            if ($existing) {
                $newValue = [
                    'position' => $i
                ];

                $model->where('folder_id', $attrib['folder_id'])
                    ->where('user_id', $attrib['user_id'])
                    ->where('media_id', $attrib['media_id'])
                    ->where('type', $attrib['type'])
                    ->update($newValue);
            } else {
                $model->insert($attrib);
            }
        }
    }

    public function updateMediaPositions(array $args = [])
    {
        $model = $this->getModel();

        $existing = $this->getFilePosition($args, $model);

        if ($existing->count() > 0) {
            $existing->update($args);
        } else {
            $model->insert($args);
        }
    }

    protected function getFilePosition(array $args = [], $model)
    {
        return $model->where('folder_id', $args['folder_id'])
            ->where('user_id', $args['user_id'])
            ->where('media_id', $args['media_id'])
            ->where('type', $args['type'])
            ->first();
    }

    /**
     * removes the selected media position details
     *
     * @param array $arrgs
     * @return void
     */
    public function removeMediaPositionData(array $args = [])
    {
        $model = $this->getModel();
        
        return $model->where('media_id', $args['media_id'])
            ->where('folder_id', $args['folder_id'])
            ->where('user_id', $args['user_id'])
            ->delete();
    }

    public function getAllMediaWithinFolder($type = 'P', $folder = 0, $userId)
    {
        $model = $this->getBuilder();

        $table = ($type == 'P') ? 'photos' : 'video';
        $model->with($table);

        return $model->where('user_id', $userId)
            ->where('folder_id', $folder)
            ->where('type', $type)
            ->orderBy('position')
            ->get();
    }
}