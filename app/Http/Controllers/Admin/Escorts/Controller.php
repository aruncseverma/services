<?php
/**
 * base class for all Escort controllers
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use App\Models\Escort;
use Illuminate\Http\Request;
use App\Repository\EscortRepository;
use App\Http\Controllers\Admin\Controller as BaseController;
use App\Support\Concerns\EscortFilterCache;

abstract class Controller extends BaseController
{
    use EscortFilterCache;

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

        // call middlewares
        $this->attachMiddleware();

        parent::__construct();
    }

    /**
     * attach middleware(s) for this controller
     *
     * @return void
     */
    abstract protected function attachMiddleware() : void;
}
