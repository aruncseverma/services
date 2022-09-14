<?php
/**
 * controller class for uploading member profile photo
 *
 */

namespace App\Http\Controllers\MemberAdmin\Profile;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Repository\PhotoRepository;
use App\Repository\MemberRepository;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\InteractsWithMemberPhotoStorage;

class UploadProfilePhotoController extends Controller
{
    use InteractsWithMemberPhotoStorage;

    /**
     * user data repository instance
     *
     * @var App\Repository\PhotoRepository
     */
    protected $photos;

    /**
     * create instance
     *
     * @param App\Repository\MemberRepository agencies
     * @param App\Repository\PhotoRepository  $photos
     */
    public function __construct(MemberRepository $agencies, PhotoRepository $photos)
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

        $member = $this->getAuthUser();
        $prev = $member->profilePhoto;

        // save to storage
        if ($path = $this->uploadMemberPhoto($request->file('profile_photo'))) {
            // delete previously set
            if (! empty($prev)) {
                $this->deleteMemberPhoto($prev->path);
            }

            // store photo information to repository
            $this->photos->store(
                [
                    'path' => $path,
                    'type' => Photo::PUBLIC_PHOTO,
                    'is_primary' => true,
                ],
                $member,
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
