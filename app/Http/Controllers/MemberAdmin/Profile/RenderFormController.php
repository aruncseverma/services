<?php
/**
 * controller class for rendering escort profile form
 *
 */

namespace App\Http\Controllers\MemberAdmin\Profile;

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
        $this->setTitle(__('Member Profile'));

        $member = $this->getAuthUser();

        // get contact platform ids (Agent)
        $memberContactPlatformIds = (is_array($member->userData->contactPlatformIds))
            ? $member->userData->contactPlatformIds
            : [];

        return view('MemberAdmin::profile.form', [
            'member' => $member,
            'languages' => $this->getLanguages(),
            'memberContactPlatformIds' => $memberContactPlatformIds
        ]);
    }
}
