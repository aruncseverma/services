<?php

namespace App\Http\Controllers\Index\Posts\Comments;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LogoutController extends BaseController
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

        // logout auth
        if ($activeGuard) {
            $activeGuard->logout();
        }

        return redirect()->back();
    }
}