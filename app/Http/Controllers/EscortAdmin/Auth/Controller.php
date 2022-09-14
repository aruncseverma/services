<?php
/**
 * auth namespace base controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Auth;

use App\Http\Controllers\EscortAdmin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * create instance
     */
    public function __construct()
    {
        parent::__construct();
    }
}
