<?php
/**
 * base controller class for attributes namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Attributes\Physical;

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
    const FALLBACK_ATTRIBUTE_NAME = Attribute::ATTRIBUTE_HAIR_COLOR;

    /**
     * repository instance
     *
     * @var App\Repository\AttributeRepository
     */
    protected $repository;

    /**
     * list of names for the attributes
     *
     * @var array
     */
    protected $attributeNames = Attribute::COMMON_PHYSICAL_ATTRIBUTES;

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

    /**
     * get attribute names
     *
     * @return array
     */
    protected function getAttributeNames() : array
    {
        return $this->attributeNames;
    }
}
