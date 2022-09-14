<?php

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use App\Models\UserLocation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Repository\AttributeRepository;
use App\Repository\LanguageRepository;

class RenderFormController extends Controller
{
    /**
     * create view instance
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view()
    {
        $user = $this->getUser();
        // set title
        $this->setTitle(__('Escort Profile'));

        // create view instance
        $view = view(
            'EscortAdmin::profile.form',
            [
                'user' => $user,
                'genderOptions'  => $this->getGenderOptions(),
                'orientation2LinerOptions' => $this->getOrientation2LinerOptions(),
                'serviceTypeOptions'  => $this->getServiceTypeOptions(),
                'socialOptions' => $this->getSocialOptions(),
                'pornstarOptions' => $this->getPornstarOptions(),
                'ethnicityOptions' => $this->getEthnicityOptions(),
                'languageOptions' => $this->getLanguageOptions(),
                'hairColorOptions' => $this->getHairColorOptions(),
                'cupSizeOptions' => $this->getCupSizeOptions(),
                'eyeColorOptions' => $this->getEyeColorOptions(),
                'hairLenght2LinerOptions' => $this->getHairLength2LinerOptions(),
                'heightOptions' => $this->getHeightOptions(),
                'weightOptions' => $this->getWeightOptions(),
                'bloodTypeOptions' => $this->getBloodTypeOptions(),
                'bustOptions' => $this->getBustOptions(),
                'escortLanguageOptions'  => $this->getEscortLanguageOptions(),
                'languageProficiencyOptions' => $this->getLanguageProficiencyOptions(),
                'remainingNumberOfAdditionalLocations' => $this->getRemainingNumberOfAdditionalLocations($user),
            ]
        );

        return $view;
    }

    /**
     * get user model
     *
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     *
     * @return App\Models\Escort
     */
    protected function getUser() : Escort
    {
        $user = $this->getAuthUser();

        if (! $user) {
            $this->notifyError(__('Requested user not found.'));
            throw new HttpResponseException(redirect()->route('escort_admin.profile'));
        } else {
            // // get all input
            // foreach (old(null, []) as $key => $value) {
            //     $user->setAttribute($key, $value);
            // }
        }

        return $user;
    }

    /**
     * populate model from old input request
     *
     * @return App\Models\User
     */
    protected function populateModelFromOldInput() : Escort
    {
        $user = $this->repository->getModel();

        // get all input
        foreach (old(null, []) as $key => $value) {
            $user->setAttribute($key, $value);
        }

        return $user;
    }

    /**
     * get gender options
     *
     * @return array
     */
    protected function getGenderOptions()
    {
        return [
            'M' => 'Male',
            'F' => 'Female',
            'B' => 'Bysexual'
        ];
    }

    /**
     * get orientation 2 liner options
     *
     * @return array
     */
    protected function getOrientation2LinerOptions()
    {
        return [
            'S' => 'Straight',
            'B' => 'Bisexual'
        ];
    }

    /**
     * get service type options
     *
     * @return array
     */
    protected function getServiceTypeOptions()
    {
        return [
            'I' => 'Incall Only',
            'O' => 'Outcall Only'
        ];
    }

    /**
     * get social options
     *
     * @return array
     */
    protected function getSocialOptions()
    {
        return [
            'Y' => 'Yes',
            'N' => 'No'
        ];
    }

    /**
     * get pornstar options
     *
     * @return array
     */
    protected function getPornstarOptions()
    {
        return [
            'Y' => 'Yes',
            'N' => 'No'
        ];
    }

    /**
     * get language options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getLanguageOptions()
    {
        $repository = app(LanguageRepository::class);
        return $repository->findAll([
            'is_active' => 1
        ]);
    }

    /**
     * get attribute options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getAttributesByName($name = '')
    {
        if (empty($name)) {
            return false;
        }

        $repository = app(AttributeRepository::class);

        return $repository->findAll([
            'name' => $name,
            'is_active' => true
        ]);
    }

    /**
     * get ethnicity options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getEthnicityOptions()
    {
        return $this->getAttributesByName('ethnicity');
    }

    /**
     * get hair color options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getHairColorOptions()
    {
        return $this->getAttributesByName('hair_color');
    }

    /**
     * get eye color options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getEyeColorOptions()
    {
        return $this->getAttributesByName('eye_color');
    }

    /**
     * get body type options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getBodyTyperOptions()
    {
        return $this->getAttributesByName('body_type');
    }

    /**
     * get cup size options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getCupSizeOptions()
    {
        return $this->getAttributesByName('cup_size');
    }

    /**
     * get escort language options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getEscortLanguageOptions()
    {
        return $this->getAttributesByName('languages');
    }

    /**
     * get language proficiency options
     *
     * @return array
     */
    protected function getLanguageProficiencyOptions()
    {
        return [
            'G' => 'Good',
            'M' => 'Moderate',
            'E' => 'Expert',
        ];
    }

    /**
     * get hair length 2 liner options
     *
     * @return array
     */
    protected function getHairLength2LinerOptions()
    {
        $min = 0.5;
        $max = 20;
        $add = $min;
        $options = [];

        for ($val = $min; $val <= $max; $val += $add) {
            $options["$val"] = sprintf('%s inches', $val);
        }

        return $options;
    }

    /**
     * get height options
     *
     * @return array
     */
    protected function getHeightOptions()
    {
        $oneInchToCm = 2.54;
        $minHeightCm = 152.4;
        $maxHeightCm = 213.36;

        $heights = [];
        for ($heightCm = $minHeightCm; $heightCm < $maxHeightCm; $heightCm += $oneInchToCm) {
            // convert centimetres to inches
            $inches = round($heightCm/2.54);
            // now find the number of feet...
            $feet = floor($inches/12);
            // ..and then inches
            $inches = ($inches%12);
            $heights["$heightCm"] = sprintf('%d\'%d"', $feet, $inches);
        }

        return $heights;
    }

    /**
     * get weight options
     *
     * @return array
     */
    protected function getWeightOptions()
    {
        $minLbs = 80;
        $maxLbs = 300;
        $weights = [];

        for ($lbs = $minLbs; $lbs <= $maxLbs; ++$lbs) {
            $weights[$lbs] = sprintf('%dlbs', $lbs);
        }

        return $weights;
    }

    /**
     * get blood type options
     *
     * @return array
     */
    protected function getBloodTypeOptions()
    {
        return [
            'A' => 'A',
            'B' => 'B',
            'AB' => 'AB',
            'O' => 'O',
        ];
    }

    /**
     * get bust options
     *
     * @return array
     */
    protected function getBustOptions()
    {
        $minCm = 80;
        $maxCm = 300;
        $busts = [];

        for ($cm = $minCm; $cm <= $maxCm; ++$cm) {
            $busts[$cm] = sprintf('%dcm', $cm);
        }

        return $busts;
    }

    /**
     * get remaining number of additional locations
     *
     * @return integer
     */
    protected function getRemainingNumberOfAdditionalLocations($user)
    {
        $max = UserLocation::MAXIMUM_ADDITIONAL_LOCATION;

        if (! $user) {
            return $max;
        }
        $total = $user->additionalLocation()->count();
        return $max - $total;
    }
}
