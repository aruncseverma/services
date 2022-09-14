<?php

namespace App\Http\Controllers\Admin\Translations;

use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsLanguages;

class ManageController extends Controller
{
    use NeedsLanguages;

    /**
     * create controller view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $this->setTitle(__('Manage Translations'));

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'group' => null,
                'key' => null,
                'text' => null,
                'limit' => $limit,
            ],
            $this->request->query()
        );

        // get translations from repository
        $translations  = $this->repository->search($limit, $search);

        // create view instance
        $view = view('Admin::translations.manage')
            ->with([
                'translations' => $translations,
                'search' => $search,
                'langCode' => app()->getLocale(),
                'languages' => $this->getLanguages(),
            ]);

        return $view;
    }
}
