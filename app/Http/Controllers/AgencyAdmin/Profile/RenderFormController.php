<?php
/**
 * controller class for rendering escort profile form
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Profile;

use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsLanguages;

class RenderFormController extends Controller
{
    use NeedsLanguages;

    /**
     * renders the form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view() : View
    {
        $this->setTitle(__('Agency Profile'));

        $agency = $this->getAuthUser();

        // get contact platform ids (Agent)
        $agencyContactPlatformIds = (is_array($agency->userData->contactPlatformIds))
            ? $agency->userData->contactPlatformIds
            : [];

        return view('AgencyAdmin::profile.form', [
            'agency' => $agency,
            'languages' => $this->getLanguages(),
            'agencyContactPlatformIds' => $agencyContactPlatformIds
        ]);
    }
}
