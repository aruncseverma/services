<?php
/**
 * Renders controls needed for the index
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Index\Home;

use Illuminate\Http\Request;
use App\Repository\StateRepository;
use App\Repository\CountryRepository;
use App\Repository\EscortListRepository;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * global variable for Request
     *
     * @var Illuminate\Http\Request
     */
    public $request;

    /**
     * global variable for EscortListRepository
     *
     * @var App\Repository\EscortListRepository
     */
    public $escortRepository;

    /**
     * countries' repository
     *
     * @var App\Repository\CountryRepository
     */
    public $countryRepository;

    /**
     * states' repository
     *
     * @var App\Repository\StateRepository
     */
    public $stateRepository;

    /**
     * Default constructor
     *
     * @param Illuminate\Http\Request               $request
     * @param App\Repository\EscortListRepository   $escortRepository
     * @param App\Repository\CountryRepository      $countryRepository
     * @param App\Repository\StateRepository        $stateRepository
     */
    public function __construct(Request $request, EscortListRepository $escortRepository, CountryRepository $countryRepository, StateRepository $stateRepository)
    {
        $this->request              = $request;
        $this->escortRepository     = $escortRepository;
        $this->countryRepository    = $countryRepository;
        $this->stateRepository      = $stateRepository;
    }
}
