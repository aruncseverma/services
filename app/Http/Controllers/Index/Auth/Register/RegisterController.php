<?php

namespace App\Http\Controllers\Index\Auth\Register;

use App\Http\Controllers\Index\Auth\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
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
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * renders register view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        // set title
        $this->setTitle(__('Resgiter'));

        // disable main wrapper
        $this->disableMainWrapper();

        return view('Index::auth.register.index');
    }
}
