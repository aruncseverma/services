<?php

namespace App\Http\Controllers\Admin\Translations;

use Illuminate\Http\Request;
use App\Repository\TranslationRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * translation repository instance
     *
     * @var App\Repository\TranslationRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\TranslationRepository $repository
     **/
    public function __construct(
        Request $request,
        TranslationRepository $repository
    ) {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }
}
