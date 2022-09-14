<?php
/**
 * manage attributes controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Attributes\Languages;

use App\Models\Attribute;
use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * manage all attributes
     *
     * @return Illuminate\Contracts\View\View
     */
    public function all() : View
    {
        $this->setTitle(__('Languages'));

        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'name'  => static::LANGUAGES_ATTRIBUTE_NAME,
                'limit' => $limit,
                'lang_code' => app()->getLocale(),
                'content' => null,
                'is_active' => '*',
            ],
            $this->request->query()
        );

        $attributes = $this->repository->search($limit, $search);

        return view('Admin::attributes.languages.manage', [
            'search' => $search,
            'attributes' => $attributes,
        ]);
    }
}
