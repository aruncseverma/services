<?php
/**
 * controller class for mail settings information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Contracts\View\View;

class MailSettingsController extends Controller
{
    /**
     * settings default type
     *
     * @const
     */
    const DEFAULT_GROUP = 'mail';

    /**
     * view site settings form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        $this->setTitle(__('Mail Settings'));

        // create view
        return view('Admin::settings.mail', ['group' => self::DEFAULT_GROUP]);
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
