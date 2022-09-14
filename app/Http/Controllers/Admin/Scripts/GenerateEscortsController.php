<?php

namespace App\Http\Controllers\Admin\Scripts;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Admin\Scripts\Concerns;

class GenerateEscortsController extends Controller
{
    use Concerns\Helpers;
    use Concerns\GenerateUser;
    use Concerns\GenerateUserData;
    use Concerns\GenerateUserDescriptions;
    use Concerns\GenerateUserLocations;
    use Concerns\GenerateLanguageProficiency;
    use Concerns\GenerateUserServices;
    use Concerns\GenerateUserRates;
    use Concerns\GenerateUserSchedules;
    use Concerns\GenerateProfileValidation;
    use Concerns\GenerateUserReviews;

    /**
     * handle incoming request data
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $total = $request->get('total', 1);
        $users = [];
        for($x = 1; $x <= $total; ++$x) {
           $user = $this->generateEscort();
           $users[$x] = $user->username;
        }
        dump($users);
        dd('DONE');
    }

    private function generateEscort()
    {
        $attributes = $this->generateUser();
        $userDataFields = $this->generateUserData();
        $descriptions = $this->generateUserDescriptions();
        $languageProficiency = $this->generateLanguageProficiency();
        $mainLocation = $this->generateUserLocationMain();
        $additionalLocations = $this->generateUserLocationAdditional();
        $userServices = $this->generateUserServices();
        $userRates = $this->generateUserRates();
        $userSchedules = $this->generateUserSchedules();
        $profileValidation = $this->generateProfileValidation();
        $reviews = $this->generateReviews();

        // dd(
        //     $attributes, 
        //         $userDataFields, 
        //         $descriptions, 
        //         $languageProficiency, 
        //         $mainLocation,
        //         $additionalLocations,
        //         $userServices, 
        //         $userRates,
        //         $userSchedules,
        //         $profileValidation,
        //         $reviews
        // );

        // save 
        $user = $this->saveUser($attributes);
        if ($user) {
            $this->saveUserData($user, $userDataFields);
            $this->saveUserDescription($user, $descriptions);
                $this->saveEscortLanguage($user, $languageProficiency);
            $this->saveUserLocation($user, $mainLocation);
            if (!empty($additionalLocations)) {
                foreach($additionalLocations as $data) {
                    $this->saveUserLocation($user, $data);
                }
            }
            if (!empty($userServices)) {
                $this->saveUserServices($user, $userServices);
            }
            if (!empty($userRates)) {
                $this->saveUserRates($user, $userRates);
            }
            if (!empty($userSchedules)) {
                $this->saveUserSchedules($user, $userSchedules);
            }
            if (!empty($profileValidation)) {
                $this->saveUserProfileValidation($user, $profileValidation);
            }
            if (!empty($reviews)) {
                $this->saveUserReviews($user, $reviews);
            }
        }
        return $user;
    }
}
