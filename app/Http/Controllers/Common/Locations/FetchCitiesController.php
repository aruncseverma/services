<?php
/**
 * common controller class to fetch list of cities from a given state key
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Common\Locations;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repository\CityRepository;
use App\Http\Controllers\Controller;

class FetchCitiesController extends Controller
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
     * @param App\Repository\CityRepository $repository
     */
    public function __construct(CityRepository $repository)
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
        $stateIds = explode(',', $request->get('stateId', ''));

        // get all countries
        $cities = $this->repository->getActiveCitiesByState($stateIds);

        return response()->json($cities);
    }
}
