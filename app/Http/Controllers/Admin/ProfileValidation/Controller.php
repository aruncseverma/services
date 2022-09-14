<?php
/**
 * base controller class for namespace ProfileValidation namespace
 *
 * @abstract
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\ProfileValidation;

use App\Repository\UserProfileValidationRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * repository instance
     *
     * @var App\Repository\UserProfileValidationRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\UserProfileValidationRepository $repository
     */
    public function __construct(UserProfileValidationRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }
}
