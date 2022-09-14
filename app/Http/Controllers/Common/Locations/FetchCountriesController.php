<?php
/**
 * common controller class to fetch list of countries from a given continent key
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Common\Locations;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repository\CountryRepository;

class FetchCountriesController extends Controller
{
    /**
     * coutnries repository instance
     *
     * @var App\Repository\CountryRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\CountryRepository $repository
     */
    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function handle(Request $request) : JsonResponse
    {
        if (! $request->expectsJson()) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        // explode
        $continentIds = explode(',', $request->get('continentId', ''));

        // get all countries
        $countries = $this->repository->getActiveCountriesByContinent($continentIds);

        return response()->json($countries);
    }
}
