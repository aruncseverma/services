<?php
/**
 * base controller for finance namespace
 *
 * 
 */

namespace App\Http\Controllers\Admin\Finance;

use Illuminate\Http\Request;
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
     * create instance
     *
     * @param Illuminate\Http\Request       $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        parent::__construct();
    }
}
