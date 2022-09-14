<?php

namespace App\Http\Controllers\MemberAdmin;

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
        return 'member_admin';
    }
}
