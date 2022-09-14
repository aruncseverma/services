<?php

namespace App\Http\Controllers\MemberAdmin\Auth;

use App\Http\Controllers\MemberAdmin\Controller as BaseController;

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
