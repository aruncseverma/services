<?php
/**
 * controller class for uploading agency profile photo
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Profile;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Repository\PhotoRepository;
use App\Repository\AgencyRepository;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\InteractsWithAgencyPhotoStorage;

class UploadProfilePhotoController extends Controller
{
    use InteractsWithAgencyPhotoStorage;

    /**
     * user data repository instance
     *
     * @var App\Repository\PhotoRepository
     */
    protected $photos;

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
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $agency = $this->getAuthUser();
        $prev = $agency->profilePhoto;

        // save to storage
        if ($path = $this->uploadAgencyPhoto($request->file('profile_photo'))) {
            // delete previously set
            if (! empty($prev)) {
                $this->deleteAgencyPhoto($prev->path);
            }

            // store photo information to repository
            $this->photos->store(
                [
                    'path' => $path,
                    'type' => Photo::PUBLIC_PHOTO,
                    'is_primary' => true,
                ],
                $agency,
                null,
                $prev
            );

            $this->notifySuccess(__('Profile photo updated successfully'));
        } else {
            // motify warning when saving to disks fails
            $this->notifyWarning(__('Profile photo failed to updated. Please try again sometime'));
        }

        return back()->withInput(['notify' => 'profile_photo']);
    }

    /**
     * validate incoming request data
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'profile_photo' => [
                    'required',
                    'image',
                    'dimensions:min_width=150,min_height=200',
                ],
            ]
        );
    }
}
