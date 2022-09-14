<?php
/**
 * manage attributes controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Attributes\Physical;

use App\Models\Attribute;
use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * manage all attributes
     *
     * @param  string $name
     *
     * @return Illuminate\Contracts\View\View
     */
    public function all($name = self::FALLBACK_ATTRIBUTE_NAME) : View
    {
        $this->setTitle(__('Common Physical Attributes'));

        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'name'  => $name,
                'limit' => $limit,
                'lang_code' => app()->getLocale(),
                'content' => null,
                'is_active' => '*',
            ],
            $this->request->query()
        );

        $attributes = $this->repository->search($limit, $search);

        return view('Admin::attributes.physical.manage', [
            'search' => $search,
            'attributes' => $attributes,
            'names' => $this->getAttributeNames()
        ]);
    }
}
