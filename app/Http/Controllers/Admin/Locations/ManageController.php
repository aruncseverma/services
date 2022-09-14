<?php
/**
 * manage all locations controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Locations;

use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * manage all locations
     *
     * @return Illuminate\Contracts\View\View
     */
    public function all() : View
    {
        $this->setTitle('Manage Locations');

        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
                'is_active' => '*',
                'name' => null,
                'continent_id' => '*',
                'country_id' => '*',
                'state_id' => '*',
            ],
            $this->request->query()
        );

        // search locations
        $locations = $this->repository->search($limit, $search);

        return view('Admin::locations.manage', [
            'search'    => $search,
            'locations' => $locations,
        ]);
    }
}
