<?php
/**
 * base controller class for all notes controller classes
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Notes;

use Illuminate\Http\Request;
use App\Repository\UserNoteRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * repository instance
     *
     * @var App\Repository\UserNoteRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param Illuminate\Http\Request           $request
     * @param App\Repository\UserNoteRepository $repository
     */
    public function __construct(Request $request, UserNoteRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }
}
