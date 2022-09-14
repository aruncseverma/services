<?php
/**
 * controller class for deleting profile photo
 *
 */

namespace App\Http\Controllers\MemberAdmin\Profile;

use App\Repository\PhotoRepository;
use App\Repository\MemberRepository;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\InteractsWithMemberPhotoStorage;

class DeleteProfilePhotoController extends Controller
{
    use InteractsWithMemberPhotoStorage;

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
     * @return RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $member = $this->getAuthUser();
        $photo = $member->profilePhoto;

        if (empty($photo)) {
            $this->notifyWarning(__('No profile photo found in your account. Please upload some'));
        } else {
            if ($this->deleteMemberPhoto($photo->path)) {
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
