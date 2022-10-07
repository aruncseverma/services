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
use App\Repository\ContinentRepository;
use App\Repository\EscortLanguageRepository;
use App\Repository\ServiceRepository;
use App\Repository\StateRepository;
use App\Repository\UserLocationRepository;
use App\Repository\EscortListRepository;
use App\Support\Concerns\NeedsCurrencies;
use Illuminate\Http\Request;
use App\Support\Concerns\EscortFilterCache;
use Cookie;
use DB;
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

        /*if (!empty($params['gender'])) {
            
            $minutes = 60;
            $cookie = cookie('gender', '$gender', $minutes);
        } elseif (empty($params['gender']) && !empty($_COOKIE['gender'])) {
            $gender = $_COOKIE['gender'];
        } else {
            $gender = 'F';
        }*/
        if (!empty($params['gender'])) {
            $gender = $params['gender'];
        }else{
            $gender = 'F';
        }
        $cityWheres = [];
        if (!empty($params['state_id'])
            &&!empty($params['country_id'])
        ) {
            $cityWheres['country_id'] = $params['country_id'];
        }

        // get escorts
        $escorts = $this->getEscortsCache($params2, function () use ($params) {
            return $this->getAllEscorts($params);
        });
        //$escorts = $this->getAllEscorts($params);
        //dd($escorts);
        if ($request->ajax()) {
            $html = view('Index::home.components.escort_listing', [
                'escorts' => $escorts
            ])->render();

            $data = [
                'html' => $html,
                'status' => 1,
                'total' => count($escorts),
            ];
            
            // request only if country is empty
            if (isset($params['continent_id']) && (!isset($params['country_id']) || empty($params['country_id']))
            ) {
                $data['countries'] = $locations->getEscortLocations('country', $params['continent_id']);
            }

            // request only if state is empty
            if (isset($params['country_id']) && (!isset($params['state_id']) || empty($params['state_id']))
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
            'continents'        => $locations->getEscortLocations('continent', ''),
            'eyeOptions'        => $this->getAttributesByName('eyes'),
            'ethnicityOptions'  => $this->escortRepository->getEthinicityByEscortTotal($params),
            'languages'         => $this->escortRepository->getEscortCountAttributes('languages', $params),
            'heightOptions'     => $this->getHeightOptions(),
            'escortServices'    => $services->getServicesFilter(1),
            'eroticServices'    => $services->getServicesFilter(2),
            'extraServices'     => $services->getServicesFilter(3),
            'fetishServices'    => $services->getServicesFilter(4),
            'hairColors'        => $this->escortRepository->getEscortCountAttributes('hair_color', $params),
            'eyeColors'         => $this->escortRepository->getEscortCountAttributes('eye_color', $params),
            'publicHairs'       => $this->escortRepository->getEscortCountAttributes('public_hair', $params),
            'hairLengthOptions' => $this->getHairLength2LinerOptions(),
            'cupSizeOptions'    => $this->escortRepository->getEscortCountAttributes('cup_size', $params),
            'travelOptions'     => $this->escortRepository->getEscortCountAttributes('travel', $params),
            'buildOptions'      => $this->escortRepository->getEscortCountAttributes('body_type', $params),
            'drinkOptions'      => $this->escortRepository->getEscortCountAttributes('drink', $params),
            'smokeOptions'      => $this->escortRepository->getEscortCountAttributes('smoke', $params),
            'escortTypeOptions' => $this->escortRepository->getEscortCountAttributes('escort_type', $params),
            'totalRecords'  => count($escorts),
        ];

        //echo $gender;exit;

        //dd($this->getGenderOptions());
        if (isset($params['country_id'])) {
            $values['states'] = $locations->getEscortLocations('state', $params['country_id']);
        }
        
        if (isset($params['state_id'])) {
            $values['cities'] = $locations->getEscortLocations('city', $params['state_id'], $cityWheres);
        }

        $values['total_with_review'] = $this->escortRepository->getTotalEscortByReview(true, $params);
        $values['total_without_review'] = $this->escortRepository->getTotalEscortByReview(false, $params);

        $values['total_with_video'] = $this->escortRepository->getTotalEscortByVideo(true, $params);
        $values['total_without_video'] = $this->escortRepository->getTotalEscortByVideo(false, $params);

        $values['total_availability'] = $this->escortRepository->getTotalEscortByAvailability($params);
        $values['originOptions'] = $this->escortRepository->getEscortOrigins($params);
        $values['femaleTotal'] = $this->escortRepository->getEscortTotalByGender('F', $params);
        $values['maleTotal'] = $this->escortRepository->getEscortTotalByGender('M', $params);
        $values['bysexualTotal'] = $this->escortRepository->getEscortTotalByGender('B', $params);
        $values['hetroTotal'] = $this->escortRepository->getEscortTotalByGender('C', $params);
        $values['verified'] = $this->escortRepository->getEscortVerificationCount('1', $params);
        $values['silver'] = $this->escortRepository->getEscortSilverGoldCount(2, $params);
        $values['gold'] = $this->escortRepository->getEscortSilverGoldCount(3, $params);
        //dd($this->escortRepository->getEthinicityByEscortTotal());
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

    public function getLocationNameBYId(Request $request)
    {
        
        $params = $request->all();
        $continent = $params['continent_id'];
        $country = $params['country_id'];
        $state = $params['state_id'];
        $city = $params['city_id'];

        $continentRepo = app(ContinentRepository::class);
        $countryRepo = app(CountryRepository::class);
        $stateRepo = app(StateRepository::class);
        $cityRepo = app(CityRepository::class);

        $str = '';

        if ($continent!='') {
            $continentdata = $continentRepo->getContinentById($continent);
            $str = $continentdata->name;
        }

        if ($country!='' && $continent!='') {
            $countrydata = $countryRepo->getCountryById($country);
            $continentdata = $continentRepo->getContinentById($continent);
            $str = $countrydata->name.','.$continentdata->name;
        }

        if ($state!='' && $country!='') {
            $countrydata = $countryRepo->getCountryById($country);
            $statedata = $stateRepo->getStateById($state);
            $str = $statedata->name.','.$countrydata->name;
        }

        if ($state!='' && $country!='' && $city!='') {
            $countrydata = $countryRepo->getCountryById($country);
            $statedata = $stateRepo->getStateById($state);
            $citydata = $cityRepo->getCityById($city);
            $str = $citydata->name . ', ' . $statedata->name. ', ' .$countrydata->name;
        }
        return $str;
    }

    protected function getFilterOptions(Request $request) {
        $params = $request->all();
        $params2 = $params;
        $locations = app(UserLocationRepository::class);
        $services = app(ServiceRepository::class);
        $ecortlist = app(EscortListRepository::class);
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

        /*if (!empty($params['gender'])) {            
            $minutes = 60;
            $cookie = cookie('gender', '$gender', $minutes);
        } elseif (empty($params['gender']) && !empty($_COOKIE['gender'])) {
            $gender = $_COOKIE['gender'];
        } else {
            $gender = 'F';
        }*/

        if (!empty($params['gender'])) {
            $gender = $params['gender'];
        } else {
            $gender = 'F';
        }

        $cityWheres = [];
        if (!empty($params['state_id'])
            &&!empty($params['country_id'])
        ) {
            $cityWheres['country_id'] = $params['country_id'];
        }

        // get escorts
        $escorts = $this->getEscortsCache($params2, function () use ($params) {
            return $this->getAllEscorts($params);
        });

        if ($request->ajax()) {

            $values = [
                'param'             => $params,
                'genderOptions'     => $this->getGenderOptions(),
                'continents'        => $locations->getEscortLocations('continent', ''),
                'eyeOptions'        => $this->getAttributesByName('eyes'),
                'ethnicityOptions'  => $this->escortRepository->getEthinicityByEscortTotal($params),
                'languages'         => $this->escortRepository->getEscortCountAttributes('languages', $params),
                'heightOptions'     => $this->getHeightOptions(),
                'escortServices'    => $services->getServicesFilter(1),
                'eroticServices'    => $services->getServicesFilter(2),
                'extraServices'     => $services->getServicesFilter(3),
                'fetishServices'    => $services->getServicesFilter(4),
                'hairColors'        => $this->escortRepository->getEscortCountAttributes('hair_color', $params),
                'eyeColors'         => $this->escortRepository->getEscortCountAttributes('eye_color', $params),
                'publicHairs'       => $this->escortRepository->getEscortCountAttributes('public_hair', $params),
                'hairLengthOptions' => $this->getHairLength2LinerOptions(),
                'cupSizeOptions'    => $this->escortRepository->getEscortCountAttributes('cup_size', $params),
                'travelOptions'     => $this->escortRepository->getEscortCountAttributes('travel', $params),
                'buildOptions'      => $this->escortRepository->getEscortCountAttributes('body_type', $params),
                'drinkOptions'      => $this->escortRepository->getEscortCountAttributes('drink', $params),
                'smokeOptions'      => $this->escortRepository->getEscortCountAttributes('smoke', $params),
                'escortTypeOptions' => $this->escortRepository->getEscortCountAttributes('escort_type', $params),
                'total_with_review' => $this->escortRepository->getTotalEscortByReview(true, $params),
                'total_without_review' => $this->escortRepository->getTotalEscortByReview(false, $params),
                'total_with_video' => $this->escortRepository->getTotalEscortByVideo(true, $params),
                'total_without_video' => $this->escortRepository->getTotalEscortByVideo(false, $params),
                'total_availability' => $this->escortRepository->getTotalEscortByAvailability($params),
                'originOptions' => $this->escortRepository->getEscortOrigins($params),
                'femaleTotal' => $this->escortRepository->getEscortTotalByGender('F', $params),
                'maleTotal' => $this->escortRepository->getEscortTotalByGender('M', $params),
                'bysexualTotal' => $this->escortRepository->getEscortTotalByGender('B', $params),
                'hetroTotal' => $this->escortRepository->getEscortTotalByGender('C', $params),
                'verified' => $this->escortRepository->getEscortVerificationCount('1', $params),
                'silver' => $this->escortRepository->getEscortSilverGoldCount(2, $params),
                'gold' => $this->escortRepository->getEscortSilverGoldCount(3, $params),
                'totalRecords' => count($escorts)
            ];
    
            if (isset($params['country_id'])) {
                $values['states'] = $locations->getEscortLocations('state', $params['country_id']);
            }
            
            if (isset($params['state_id'])) {
                $values['cities'] = $locations->getEscortLocations('city', $params['state_id'], $cityWheres);
            }
            //dd($values);
            $html = view('Index::home.components.home_ajax_filter', [
                'values' => $values
            ])->render();

            $data = [
                'html' => $html,
                'status' => 1,
            ];
            return response()->json($data);
        }
    }
}