<?php
/**
 * controller class for deleting profile photo
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Profile;

use App\Repository\PhotoRepository;
use App\Repository\AgencyRepository;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\InteractsWithAgencyPhotoStorage;

class DeleteProfilePhotoController extends Controller
{
    use InteractsWithAgencyPhotoStorage;

    /**
     * create instance
     *
     * @param App\Repository\AgencyRepository agencies
     * @param App\Repository\PhotoRepository  $photos
     */
    public function __construct(AgencyRepository $agencies, PhotoRepository $photos)
    {
        parent::__construct($agencies);
        $this->photos = $photos;
    }

    /**
     * handle incoming request
     *
     * @return RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $agency = $this->getAuthUser();
        $photo = $agency->profilePhoto;

        if (empty($photo)) {
            $this->notifyWarning(__('No profile photo found in your account. Please upload some'));
        } else {
            if ($this->deleteAgencyPhoto($photo->path)) {
                // delete to repository
                $this->photos->delete($photo->getKey());
                $this->notifySuccess(__('Profile photo removed successfully'));
            } else {
                $this->notifyWarning(__('Unable to remove profile photo. Please try again sometime'));
            }
        }

        return back()->withInput(['notify' => 'profile_photo']);
    }
}
