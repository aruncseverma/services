<?php
/**
 * controller class for site settings information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Contracts\View\View;

class SiteSettingsController extends Controller
{
    /**
     * settings default type
     *
     * @const
     */
    const DEFAULT_GROUP = 'site';

    /**
     * view site settings form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        $this->setTitle(__('Site Settings'));

        // create view
        return view('Admin::settings.site', ['group' => self::DEFAULT_GROUP]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:general_settings.manage');
    }
}
