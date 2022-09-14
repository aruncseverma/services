<?php
/**
 * manage languages controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Languages;

use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * all languages view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function all() : View
    {
        // set title
        $this->setTitle(__('Manage Languages'));

        // search params
        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
                'name'  => null,
                'is_active' => '*',
                'code'  => null,
            ],
            $this->request->query()
        );

        $languages = $this->repository->search($limit, $search);

        // create view instance
        $view = view('Admin::languages.manage')
            ->with([
                'search' => $search,
                'languages' => $languages,
            ]);

        return $view;
    }
}
