<?php

namespace App\Http\Controllers\Index\Posts\Comments;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Administrator;
use App\Models\Agency;
use App\Models\Escort;
use App\Models\Member;

class ProfileController extends BaseController
{
    /**
     * handles incoming request
     *
     * @param Request $request
     * 
     * @return RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        // get auth guard
        $activeGuard = $this->getActiveAuthGuard();

        // redirect to auth profile
        if ($activeGuard) {
            $auth = $activeGuard->user();
            if ($auth) {
                $profileUrl = null;
                switch ($auth->type) {
                    case Administrator::USER_TYPE:
                        $profileUrl = route('admin.administrator.update', ['id' => $auth->getKey()]);
                        break;
                    case Agency::USER_TYPE:
                        $profileUrl = route('agency_admin.profile');
                        break;
                    case Escort::USER_TYPE:
                        $profileUrl = route('escort_admin.profile');
                        break;
                    case Member::USER_TYPE:
                        $profileUrl = route('member_admin.profile');
                        break;
                }
                if ($profileUrl) {
                    return redirect($profileUrl);
                }
            }
        }

        return redirect()->back();
    }
}
