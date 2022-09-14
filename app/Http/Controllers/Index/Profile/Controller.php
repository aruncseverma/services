<?php

namespace App\Http\Controllers\Index\Profile;

use Illuminate\Http\Request;
use App\Models\Escort;
use App\Repository\EscortRepository;
use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
   /**
    * default type
    *
    * @const
    */
    const DEFAULT_TYPE = Escort::USER_TYPE;

    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * users repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $repository;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request       $request
     * @param App\Repository\EscortRepository $repository
     */
    public function __construct(Request $request, EscortRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        //parent::__construct();
    }

    /**
     * get escort data by id
     *
     * @param  mixed $id
     *
     * @return App\Models\Escort|null
     */
    public function getEscortById($id) : ?Escort
    {
        $repository = app(EscortRepository::class);
        return $repository->find($id);
    }
}
