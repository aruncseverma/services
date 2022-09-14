<?php
/**
 * agency listing controller
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Index\Agency;

use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return view
     */
    public function view(Request $request)
    {
        $this->setTitle(__('Agency Page'));

        $search = $request->query();
        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'name'      => null,
                'is_active' => '*',
                'type'      => self::DEFAULT_TYPE,
                'limit'     => $limit,
            ],
            $search
        );

        $countries = $this->userLocationRepository->getAgencyLocations('country', '');
        // $agencies = $this->agencyRepository->getAll();
        $agencies = $this->agencyRepository->search($limit, $search);

        return view('Index::agency.index', [
            'countries' => $countries,
            'agencies' => $agencies
        ]);
    }
}