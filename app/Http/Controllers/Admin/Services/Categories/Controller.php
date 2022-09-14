<?php
/**
 * base controller for service categories namespace
 *
 * @abstract
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services\Categories;

use App\Repository\ServiceCategoryRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * service category repository
     *
     * @var App\Repository\ServiceCategoryRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\ServiceCategoryRepository $repository
     */
    public function __construct(ServiceCategoryRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }
}
