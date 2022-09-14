<?php
/**
 * manage controller class for rates duration
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\RateDurations;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * render view for manage page
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view(Request $request) : View
    {
        $this->setTitle(__('Manage Rate Durations'));

        $search = array_merge(
            [
                'name' => null,
                'lang_code' => app()->getLocale(),
                'limit' => $limit = $this->getPageSize(),
                'is_active' => '*'
            ],
            $request->query()
        );

        $durations = $this->durationRepository->search($limit, $search);

        // render view
        return view('Admin::rate_durations.manage', [
            'search' => $search,
            'durations' => $durations,
        ]);
    }
}
