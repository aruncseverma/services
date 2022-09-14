<?php
/**
 * base controller class for member admin profile namespace
 *
 * @abstract
 */

namespace App\Http\Controllers\MemberAdmin\Profile;

use App\Repository\MemberRepository;
use App\Http\Controllers\MemberAdmin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * create instance
     *
     * @param App\Repository\MemberRepository $agencies
     */
    public function __construct(MemberRepository $agencies)
    {
        $this->agencies = $agencies;

        parent::__construct();
    }
}
