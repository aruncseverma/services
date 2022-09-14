<?php
/**
 * controller class for updating agency about information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Profile;

use App\Models\Agency;
use Illuminate\Http\Request;
use App\Repository\AgencyRepository;
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
     * @param App\Repository\AgencyRepository           $agencies
     * @param App\Repository\UserDescriptionRepository $descriptions
     */
    public function __construct(AgencyRepository $agencies, UserDescriptionRepository $descriptions)
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

        $agency = $this->getAuthUser();

        // save descriptions
        $this->saveAboutAgency($request, $agency);

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
     * save about agency information
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Agency       $agency
     *
     * @return App\Models\Agency
     */
    protected function saveAboutAgency(Request $request, Agency $agency) : Agency
    {
        foreach ($request->input('about') as $code => $content) {
            $description = $agency->getDescription($code, false);
            $this->descriptions->store(
                [
                    'lang_code' => $code,
                    'content' => $content,
                ],
                $agency,
                $description
            );
        }

        return $agency;
    }
}
