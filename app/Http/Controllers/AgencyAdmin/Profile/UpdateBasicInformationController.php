<?php
/**
 * controller class for updating basic information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Profile;

use App\Models\Agency;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use App\Repository\AgencyRepository;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserLocationRepository;

class UpdateBasicInformationController extends Controller
{
    /**
     * create instance
     *
     * @param App\Repository\AgencyRepository       $agencies
     * @param App\Repository\UserLocationRepository $locations
     */
    public function __construct(AgencyRepository $agencies, UserLocationRepository $locations)
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

        $agency = $this->getAuthUser();

        // save basic information related to agency
        $this->saveBasicInformation($request, $agency);

        // save location
        $this->saveLocation($request, $agency);

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
                'agency_name' => 'required',
                'continent_id' => 'required|continents',
                'country_id' => 'required|countries',
                'state_id' => 'required|states',
                'city_id' => 'required|cities',
            ]
        );
    }

    /**
     * save basic information of the agency
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Agency       $agency
     *
     * @return App\Models\Agency
     */
    protected function saveBasicInformation(Request $request, Agency $agency) : Agency
    {
        $agency = $this->agencies->save(
            [
                'name' => $request->input('agency_name')
            ],
            $agency
        );

        return $agency;
    }

    /**
     * save location information
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Agency       $agency
     *
     * @return App\Models\UserLocation
     */
    protected function saveLocation(Request $request, Agency $agency) : UserLocation
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
            $agency,
            $agency->mainLocation
        );

        return $location;
    }
}
