<?php
/**
 * controller class for managing agency escort
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Escorts;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\AgencyAdmin\Controller;

class ManageController extends Controller
{
    /**
     * render manage view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        $this->setTitle(__('Escorts'));

        $agency = $this->getAuthUser();

        return view('AgencyAdmin::escorts.manage', [
            'escorts' => $agency->escorts,
        ]);
    }
}
