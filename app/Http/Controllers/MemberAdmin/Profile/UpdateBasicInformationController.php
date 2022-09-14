<?php
/**
 * controller class for updating basic information
 *
 */

namespace App\Http\Controllers\MemberAdmin\Profile;

use App\Models\Member;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use App\Repository\MemberRepository;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserLocationRepository;

class UpdateBasicInformationController extends Controller
{
    /**
     * create instance
     *
     * @param App\Repository\MemberRepository       $agencies
     * @param App\Repository\UserLocationRepository $locations
     */
    public function __construct(MemberRepository $agencies, UserLocationRepository $locations)
    {
        parent::__construct($agencies);

        $this->locations = $locations;
    }

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $member = $this->getAuthUser();

        // save basic information related to member
        $this->saveBasicInformation($request, $member);

        // save location
        $this->saveLocation($request, $member);

        // notify success save
        $this->notifySuccess(__('Basic Information saved successfully'));

        // redirect from previous action
        return back()->withInput(['notify' => 'basic_info']);
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
                'member_name' => 'required',
                'continent_id' => 'required|continents',
                'country_id' => 'required|countries',
                'state_id' => 'required|states',
                'city_id' => 'required|cities',
            ]
        );
    }

    /**
     * save basic information of the member
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Member       $member
     *
     * @return App\Models\Member
     */
    protected function saveBasicInformation(Request $request, Member $member) : Member
    {
        $member = $this->agencies->save(
            [
                'name' => $request->input('member_name')
            ],
            $member
        );

        return $member;
    }

    /**
     * save location information
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Member       $member
     *
     * @return App\Models\UserLocation
     */
    protected function saveLocation(Request $request, Member $member) : UserLocation
    {
        // save locations request
        $location = $this->locations->store(
            array_merge(
                $request->only([
                    'continent_id',
                    'country_id',
                    'state_id',
                    'city_id',
                ]),
                [
                    'type' => UserLocation::MAIN_LOCATION_TYPE,
                ]
            ),
            $member,
            $member->mainLocation
        );

        return $location;
    }
}
