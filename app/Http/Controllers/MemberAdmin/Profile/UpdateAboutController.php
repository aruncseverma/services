<?php
/**
 * controller class for updating member about information
 *
 */

namespace App\Http\Controllers\MemberAdmin\Profile;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Repository\MemberRepository;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserDescriptionRepository;

class UpdateAboutController extends Controller
{
    /**
     * user descriptions repository
     *
     * @var App\Repository\UserDescriptionRepository
     */
    protected $descriptions;

    /**
     * create instance
     *
     * @param App\Repository\MemberRepository           $agencies
     * @param App\Repository\UserDescriptionRepository $descriptions
     */
    public function __construct(MemberRepository $agencies, UserDescriptionRepository $descriptions)
    {
        parent::__construct($agencies);

        $this->descriptions = $descriptions;
    }

    /**
     * handles incoming request
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $member = $this->getAuthUser();

        // save descriptions
        $this->saveAboutMember($request, $member);

        $this->notifySuccess(__('About was successfully saved'));

        return back()->withInput(['notify' => 'about']);
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
                'about.*' => 'required'
            ]
        );
    }

    /**
     * save about member information
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Member       $member
     *
     * @return App\Models\Member
     */
    protected function saveAboutMember(Request $request, Member $member) : Member
    {
        foreach ($request->input('about') as $code => $content) {
            $description = $member->getDescription($code, false);
            $this->descriptions->store(
                [
                    'lang_code' => $code,
                    'content' => $content,
                ],
                $member,
                $description
            );
        }

        return $member;
    }
}
