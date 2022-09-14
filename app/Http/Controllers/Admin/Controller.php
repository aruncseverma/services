<?php
/**
 * admin namespace base controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * create instance
     */
    public function __construct()
    {
        $this->middleware('auth:' . $this->getAuthGuardName());
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getAuthGuardName() : string
    {
        return 'admin';
    }
}
