<?php
/**
 * handles change in media positioning
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Videos;

use App\Repository\MediaPositionRepository;
use Illuminate\Http\Request;

class UpdateVideoPositionController extends Controller
{

    /**
     * handles changes in position
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request)
    {
        $userId = $this->getAuthUser()->getKey();
        $positions = $request->video_arrangement;
        $folder = $request->folder_id;
        $arrangement = (is_array($positions)) ? $positions : explode(',', $positions);
        $this->position->rearrangeMedia($arrangement, 'V', $userId, $folder, null);

        return json_encode([
            'success' => true
        ]);
    }
}