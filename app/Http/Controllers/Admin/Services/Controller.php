<?php
/**
 * base controller for services namespace
 *
 * @abstract
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services;

use App\Repository\ServiceRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * create instance
     *
     * @param App\Repository\ServiceRepository $repository
     */
    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;

        // call parent constructor
        parent::__construct();
    }
}
