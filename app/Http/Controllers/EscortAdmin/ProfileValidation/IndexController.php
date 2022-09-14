<?php
/**
 * index controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\ProfileValidation;

use App\Models\UserGroup;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * renders profile validation form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view() : View
    {
        $this->setTitle(__('Private Profile & Validation'));

        $escort = $this->getAuthUser();
        $membership = 'basic';

        // checks current membership
        if (optional($escort->userGroup)->getKey() === UserGroup::SILVER_GROUP_ID) {
            $membership = 'silver';
        } elseif (optional($escort->userGroup)->getKey() === UserGroup::GOLD_GROUP_ID) {
            $membership = 'gold';
        }

        return view('EscortAdmin::profile_validation.form', [
            'escort' => $escort,
            'membership' => $membership,
        ]);
    }
}
