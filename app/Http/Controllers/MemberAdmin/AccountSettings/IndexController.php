<?php
/**
 * account settings index controller
 *
 */

namespace App\Http\Controllers\MemberAdmin\AccountSettings;

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

        return view('MemberAdmin::account_settings.form', [
            'user' => $user = $this->getAuthUser(),
            'banIds' => collect($user->banCountries)->map(function ($ban) {
                return $ban->country->getKey();
            })->all(),
        ]);
    }
}
