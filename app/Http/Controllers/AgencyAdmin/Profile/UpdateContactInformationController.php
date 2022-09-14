<?php
/**
 * controller class for contact information updates
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Profile;

use App\Models\Agency;
use Illuminate\Http\Request;
use App\Repository\AgencyRepository;
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
     * @param App\Repository\AgencyRepository   $agencies
     * @param App\Repository\UserDataRepository $userData
     */
    public function __construct(AgencyRepository $agencies, UserDataRepository $userData)
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

        // get currently authenticated agency
        $agency = $this->getAuthUser();

        // update agency phone
        $this->updateAgencyPhone($agency, $request->input('phone'));

        // update agency data
        $this->updateAgencyUserData($agency, $request->input('user_data'));

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
                'user_data.website' => 'nullable|url',
                'user_data.skype_id' => 'nullable',
                'user_data.contact_platform_ids' => 'nullable|array',
                'phone' => 'nullable',
            ],
            [],
            [
                'user_data.website' => 'website',
                'user_data.skype_id' => 'skype id',
                'user_data.contact_platform_ids' => 'contact platforms',
            ]
        );
    }

    /**
     * update agency contact number
     *
     * @param  App\Models\Agency $agency
     * @param  string|null       $phone
     *
     * @return App\Models\Agency
     */
    protected function updateAgencyPhone(Agency $agency, ?string $phone = null) : Agency
    {
        $agency = $this->agencies->save(['phone' => $phone], $agency);

        return $agency;
    }

    /**
     * update agency user data
     *
     * @param  App\Models\Agency $agency
     * @param  array             $data
     *
     * @return App\Models\Agency
     */
    protected function updateAgencyUserData(Agency $agency, array $data = []) : Agency
    {
        $this->userData->saveUserData($agency, $data);

        return $agency;
    }
}
