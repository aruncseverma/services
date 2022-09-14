<?php
/**
 * account settings index controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\AccountSettings;

use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * render account settings form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        $this->setTitle(__('Account Settings'));

        return view('AgencyAdmin::account_settings.form', [
            'user' => $user = $this->getAuthUser(),
            'banIds' => collect($user->banCountries)->map(function ($ban) {
                return $ban->country->getKey();
            })->all(),
        ]);
    }
}
