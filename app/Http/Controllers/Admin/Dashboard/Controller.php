<?php
/**
 * dashboard namespace base controller
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Dashboard;

use App\Repository\AgencyRepository;
use App\Repository\EscortRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
   /**
    * escort repository instance
    *
    * @var App\Repository\EscortRepository
    */
    protected $escortRepository;

    /**
     * agency repository instance
     *
     * @var App\Repository\AgencyRepository
     */
    protected $agencyRepository;

    /**
     * create instance
     *
     * @param App\Repository\EscortRepository $escortRepository
     * @param App\Repository\AgencyRepository $agencyRepository
     */
    public function __construct(
        EscortRepository $escortRepository,
        AgencyRepository $agencyRepository
    ) {
        $this->escortRepository = $escortRepository;
        $this->agencyRepository = $agencyRepository;

        parent::__construct();
    }
}
