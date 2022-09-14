<?php
/**
 * Controlls the home page for the users
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Index\Home;

use Illuminate\Contracts\View\View;
use App\Repository\AttributeRepository;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\EscortLanguageRepository;
use App\Repository\ServiceRepository;
use App\Repository\StateRepository;
use App\Repository\UserLocationRepository;
use App\Support\Concerns\NeedsCurrencies;
use Illuminate\Http\Request;
use App\Support\Concerns\EscortFilterCache;

class IndexController extends Controller
{
    use NeedsCurrencies;
    use EscortFilterCache;

    /**
     * Renders the view for the homepage
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view(Request $request)
    {
        $params = $request->all();
        $params2 = $params;

        $this->setTitle(__('Home Page'));

        $locations = app(UserLocationRepository::class);
        $services = app(ServiceRepository::class);
        $attributes = app(AttributeRepository::class);

        if (!empty($request->getRequestUri())) {
            $arrangement = [
                '',
                'excess',
                'country',
                'state',
                'city'
            ];

            $uri = explode('/', $request->getRequestUri());
            for ($k = 0; $k < count($uri); $k++) {
                $params[$arrangement[$k]] = urldecode($uri[$k]);
            }

            if (isset($params['country'])) {
                $params = $this->handleLocationFilter($params);
            }
        }

        $cityWheres = [];
        if (!empty($params['state_id'])
            &&!empty($params['country_id'])
        ) {
            $cityWheres['country_id'] = $params['country_id'];
        }

        // get escorts
        $escorts = $this->getEscortsCache($params2, function() use ($params) {
            return $this->getAllEscorts($params);
        });

        if ($request->ajax()) {
            $html = view('Index::home.components.escort_listing', [
                'escorts' => $escorts
            ])->render();

            $data = [
                'html' => $html,
                'status' => 1,
                'total' => count($escorts),
            ];

            // request only if state is empty
            if (isset($params['country_id'])
                && (!isset($params['state_id']) || empty($params['state_id']))
            ) {
                $data['states'] = $locations->getEscortLocations('state', $params['country_id']);
            }
            // request only if city is empty
            if (isset($params['state_id']) 
                && (!isset($params['city_id']) || empty($params['city_id']))
            ) {
                $data['cities'] = $locations->getEscortLocations('city', $params['state_id'], $cityWheres);
            }

            return response()->json($data);
        }

        $values = [
            'param'             => $params,
            'escorts'           => $escorts,
            'genderOptions'     => $this->getGenderOptions(),
            'countries'         => $locations->getEscortLocations('country', ''),
            'eyeOptions'        => $this->getAttributesByName('eyes'),
            'ethnicityOptions'  => $this->getEthnicityOptions(),
            'languages'         => $this->getLanguageFilters(),
            'heightOptions'     => $this->getHeightOptions(),
            'escortServices'    => $services->getServicesFilter(1),
            'eroticServices'    => $services->getServicesFilter(2),
            'extraServices'     => $services->getServicesFilter(3),
            'fetishServices'    => $services->getServicesFilter(4),
            'hairColors'        => $attributes->getEscortHairColorFilter(),
            'eyeColors'         => $attributes->getEscortEyeColorFilter(),
            'hairLengthOptions' => $this->getHairLength2LinerOptions(),
        ];

        if (isset($params['country_id'])) {
            $values['states'] = $locations->getEscortLocations('state', $params['country_id']);
        }
        
        if (isset($params['state_id'])) {
            $values['cities'] = $locations->getEscortLocations('city', $params['state_id'], $cityWheres);
        }

        $values['total_with_review'] = $this->escortRepository->getTotalEscortByReview(true);
        $values['total_without_review'] = $this->escortRepository->getTotalEscortByReview(false);

        $values['total_with_video'] = $this->escortRepository->getTotalEscortByVideo(true);
        $values['total_without_video'] = $this->escortRepository->getTotalEscortByVideo(false);

        $values['total_availability'] = $this->escortRepository->getTotalEscortByAvailability();
        $values['originOptions'] = $this->escortRepository->getEscortOrigins();
        return view('Index::home.index', $values);
    }

    /**
     * Undocumented function
     *
     * @param array $params
     * @return array $params
     */
    private function handleLocationFilter($params)
    {
        $countryRepo = app(CountryRepository::class);
        $stateRepo = app(StateRepository::class);
        $cityRepo = app(CityRepository::class);

        $country = $countryRepo->getCountryByName($params['country']);

        if ($country) {
            $params['country_id'] = $country->id;
        }

        if (isset($params['state'])) {
            $state = $stateRepo->getStateByName($params['state'], $country->id);
            $params['state_id'] = $state->id;
        }

        if (isset($params['city'])) {
            $city = $cityRepo->getCityByName($params['city'], $state->id);
            $params['city_id'] = $city->id;
        }

        return $params;
    }

    /**
     * Undocumented function
     *
     * @param array $params
     * @return void
     */
    protected function getAllEscorts(array $params)
    {
        $escorts = $this->escortRepository->filter($params);
        $currencies = $this->getCurrencies();
        $currentCurrency = $currencies->first();

        foreach($escorts as $key => $value) {
            $profileImageUrl = $value->getProfileImage();
            $profileImageData = [];
            if (!empty($profileImageUrl)) {
                $profileImageData = $value->profilePicture()->first()->data;
            }
            $value->setAttribute('profilePicture', $profileImageUrl);
            $value->setAttribute('profilePictureData', $profileImageData);
            $value->setAttribute('age', $value->getAgeAttribute());
            $value->setAttribute('rate', $value->getRate($value->id, $currentCurrency));
            $value->setAttribute('service', $value->getService($value->id));
            $value->setAttribute('origin', $value->getOriginAttribute());

            $countryId = $value->mainLocation()->first();

            $value->setAttribute('mainLocation', $this->getEscortMainLocation($countryId));
            $value->setAttribute('originFlag', mb_strtolower($value->getOriginCodeAttribute() . '.png'));
            $value->setAttribute('ethnicity', $value->getEthnicityAttribute());
            $value->setAttribute('serviceType', $value->getServiceTypeAttribute());
        }

        return $escorts;
    }

    protected function getLanguageFilters()
    {
        $repo = app(AttributeRepository::class);
        return $repo->getEscortLanguageFilter();
    }

    /**
     * get escort's main location
     *
     * @param String $countryId
     * @return string|null
     */
    protected function getEscortMainLocation($countryId) : ?string
    {
        if ($countryId == null) {
            return null;
        }

        $mainLocation = $this->countryRepository->find($countryId)->first();

        if ($mainLocation != null) {
            return $mainLocation->first()->name;
        }

        return null;
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
     * get ethnicity attributes
     *
     * @return Illuminate\Support\Collection
     */
    protected function getEthnicityOptions()
    {
        return $this->getAttributesByName('ethnicity');
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

        return $repository->getFilter([
            'name' => $name,
            'is_active' => true
        ]);
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
}