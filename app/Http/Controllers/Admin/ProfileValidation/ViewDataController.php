<?php
/**
 * controller class for viewing data from specified membership request
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\ProfileValidation;

use App\Models\UserGroup;
use App\Models\UserProfileValidation;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsStorage;

class ViewDataController extends Controller
{
    use NeedsStorage;

    /**
     * renders the information of membership requested
     *
     * @param  App\Models\UserProfileValidation $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(UserProfileValidation $model) : View
    {
        $userGroup = $model->userGroup;
        $view = null;

        switch ($userGroup->getKey()) {
            case UserGroup::GOLD_GROUP_ID:
                $view = $this->renderViewDataForGoldMembership($model);
                break;
            case UserGroup::SILVER_GROUP_ID:
                $view = $this->renderViewDataForSilverMembership($model);
                break;
            default:
                abort(404);
        }

        return $view;
    }

    /**
     * renders view for silver membership requirements
     *
     * @param  App\Models\UserProfileValidation $model
     *
     * @return Illuminate\Contracts\View\View
     */
    protected function renderViewDataForSilverMembership(UserProfileValidation $model) : View
    {
        $data = $model->data;
        $photo = null;
        $mimeType = null;
        $storage =  $this->getStorage()->disk($this->getDiskNameForMugShots());

        // process uploaded file
        if (isset($data[$this->getDiskNameForMugShots() . '_path'])) {
            $path = $data[$this->getDiskNameForMugShots() . '_path'];
            $photo = $storage->get($path);
            $mimeType = $storage->mimeType($path);
        }

        return view('Admin::profile_validation.components.view_data.silver', [
            'mimeType' => $mimeType,
            'photo' => $photo,
        ]);
    }

    /**
     * render requirements view for gold membership
     *
     * @param  App\Models\UserProfileValidation $model
     *
     * @return Illuminate\Contracts\View\View
     */
    protected function renderViewDataForGoldMembership(UserProfileValidation $model) : View
    {
        $data = $model->data;

        // should not return any information
        if (! isset($data['info'])) {
            return abort(404);
        }

        // process information
        $info = json_decode(decrypt($data['info']), true);
        $photo = [];
        $storage = $this->getStorage()->disk($this->getDiskNameForPrivatePhotoId());

        // get raw content of the photo
        if (isset($data[$this->getDiskNameForPrivatePhotoId() . '_path'])) {
            $path = $data[$this->getDiskNameForPrivatePhotoId() . '_path'];
            $photo['raw'] = $storage->get($path);
            $photo['mime'] = $storage->mimeType($path);
        }

        return view('Admin::profile_validation.components.view_data.gold', [
            'info' => $info,
            'photo' => $photo
        ]);
    }
}
