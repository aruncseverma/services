<?php
/**
 * controller class for contact information updates
 *
 */

namespace App\Http\Controllers\MemberAdmin\Profile;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Repository\MemberRepository;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserDataRepository;

class UpdateContactInformationController extends Controller
{
    /**
     * user data repository instance
     *
     * @var App\Repository\UserDataRepository
     */
    protected $userData;

    /**
     * create instance
     *
     * @param App\Repository\MemberRepository   $agencies
     * @param App\Repository\UserDataRepository $userData
     */
    public function __construct(MemberRepository $agencies, UserDataRepository $userData)
    {
        parent::__construct($agencies);
        $this->userData = $userData;
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
        // validate request information
        $this->validateRequest($request);

        // get currently authenticated member
        $member = $this->getAuthUser();

        // update member phone
        $this->updateMemberPhone($member, $request->input('phone'));

        // update member data
        $this->updateMemberUserData($member, $request->input('user_data'));

        $this->notifySuccess(__('Contact information updated successfully'));

        return back()->withInput(['notify' => 'contact_information']);
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
                'user_data' => 'array',
                'user_data.facebook' => 'nullable|url',
                'user_data.skype_id' => 'nullable',
                'user_data.contact_platform_ids' => 'nullable|array',
                'phone' => 'nullable',
            ],
            [],
            [
                'user_data.facebook' => 'facebook',
                'user_data.skype_id' => 'skype id',
                'user_data.contact_platform_ids' => 'contact platforms',
            ]
        );
    }

    /**
     * update member contact number
     *
     * @param  App\Models\Member $member
     * @param  string|null       $phone
     *
     * @return App\Models\Member
     */
    protected function updateMemberPhone(Member $member, ?string $phone = null) : Member
    {
        $member = $this->agencies->save(['phone' => $phone], $member);

        return $member;
    }

    /**
     * update member user data
     *
     * @param  App\Models\Member $member
     * @param  array             $data
     *
     * @return App\Models\Member
     */
    protected function updateMemberUserData(Member $member, array $data = []) : Member
    {
        $this->userData->saveUserData($member, $data);

        return $member;
    }
}
