<?php
/**
 * controller class for managing service categories
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services\Categories;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * renders manage view
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view(Request $request) : View
    {
        $this->setTitle(__('Manage Service Categories'));

        $search = array_merge(
            [
                'name' => null,
                'is_active' => '*',
                'limit' => $limit = $this->getPageSize(),
                'lang_code' => app()->getLocale(),
            ],
            $request->query()
        );

        // fetch categories
        $categories = $this->repository->search($limit, $search);

        return view('Admin::services.categories.manage', [
            'categories' => $categories,
            'search' => $search,
        ]);
    }
}
