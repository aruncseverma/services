<?php
/**
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Contracts\View\View;

/**
 * renders the form for the image settings in the admin backend site
 */
class ImageSettingsController extends Controller
{
    /**
     * settings default type
     *
     * @const
     */
    const DEFAULT_GROUP = 'image';

    /**
     * view site settings form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        $this->setTitle(__('Image Settings'));

        // create view
        return view('Admin::settings.image', ['group' => self::DEFAULT_GROUP]);
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
