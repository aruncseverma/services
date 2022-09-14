<?php
/**
 * base controller class for attributes namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Attributes\Languages;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Repository\AttributeRepository;
use App\Http\Controllers\Admin\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * fallback attribute name
     *
     * @const
     */
    const LANGUAGES_ATTRIBUTE_NAME = Attribute::ATTRIBUTE_LANGUAGES;

    /**
     * repository instance
     *
     * @var App\Repository\AttributeRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param Illuminate\Http\Request            $request
     * @param App\Repository\AttributeRepository $repository
     */
    public function __construct(Request $request, AttributeRepository $repository)
    {
        $this->request    = $request;
        $this->repository = $repository;

        parent::__construct();
    }
}
