<?php
/**
 * manage services controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsServiceCategories;

class ManageController extends Controller
{
    use NeedsServiceCategories;

    public function view(Request $request) : View
    {
        $this->setTitle(__('Manage Services'));

        $search = array_merge(
            [
                'name' => null,
                'is_active' => '*',
                'service_category_id' => '*',
                'limit' => $limit = $this->getPageSize(),
                'lang_code' => app()->getLocale(),
            ],
            $request->query()
        );

        $services = $this->repository->search($limit, $search);
        $categories = $this->getServiceCategories();

        return view('Admin::services.manage', [
            'services' => $services,
            'search' => $search,
            'categories' => $categories,
        ]);
    }
}
