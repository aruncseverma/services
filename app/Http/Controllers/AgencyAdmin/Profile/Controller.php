<?php
/**
 * base controller class for agency admin profile namespace
 *
 * @abstract
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Profile;

use App\Repository\AgencyRepository;
use App\Http\Controllers\AgencyAdmin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * create instance
     *
     * @param App\Repository\AgencyRepository $agencies
     */
    public function __construct(AgencyRepository $agencies)
    {
        $this->agencies = $agencies;

        parent::__construct();
    }
}
