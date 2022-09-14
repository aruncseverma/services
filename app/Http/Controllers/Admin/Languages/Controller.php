<?php
/**
 * base controller class for all languages controller classes
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Languages;

use Illuminate\Http\Request;
use App\Repository\CountryRepository;
use App\Repository\LanguageRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * request instance
     *
     * @var Illuminate\Http\Reques
     */
    protected $request;

    /**
     * repository instance
     *
     * @var App\Repository\LanguageRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param Illuminate\Http\Request           $request
     * @param App\Repository\LanguageRepository $repository
     */
    public function __construct(Request $request, LanguageRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * get country repository
     *
     * @return App\Repository\CountryRepository
     */
    protected function getCountryRepository() : CountryRepository
    {
        return app(CountryRepository::class);
    }
}
