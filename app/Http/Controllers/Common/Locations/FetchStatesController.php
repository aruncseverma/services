<?php
/**
 * common controller class to fetch list of states from a given country key
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Common\Locations;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repository\StateRepository;
use App\Http\Controllers\Controller;

class FetchStatesController extends Controller
{
    /**
     * states repository instance
     *
     * @var App\Repository\StateRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\StateRepository $repository
     */
    public function __construct(StateRepository $repository)
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

        // explode country ids
        $countryId = explode(',', $request->get('countryId', ''));

        // get states
        $states = $this->repository->getActiveStatesByCountry($countryId);

        return response()->json($states);
    }
}
