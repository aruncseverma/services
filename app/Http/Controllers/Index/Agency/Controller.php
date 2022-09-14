<?php

namespace App\Http\Controllers\Index\Agency;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Agency;
use App\Repository\AgencyRepository;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\StateRepository;
use App\Repository\UserLocationRepository;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    
   /**
    * default type
    *
    * @const
    */
    const DEFAULT_TYPE = Agency::USER_TYPE;

    /**
     * request
     *
     * @var Illuminate\Http\Request
     */
    public $request;

    /**
     * agencies' repository
     *
     * @var App\Repository\AgencyRepository
     */
    public $agencyRepository;

    /**
     * Undocumented variable
     *
     * @var App\Repository\UserLocationRepository
     */
    public $userLocationRepository;

    /**
     * default controller constructor
     *
     * @param Request $request
     * @param AgencyRepository $agencyRepo
     * @param UserLocationRepository $userLocationRepo
     */
    public function __construct(Request $request, AgencyRepository $agencyRepo, UserLocationRepository $userLocationRepo)
    {
        $this->request = $request;
        $this->agencyRepository = $agencyRepo;
        $this->userLocationRepository = $userLocationRepo;
    }
}