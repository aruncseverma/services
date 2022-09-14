<?php
/**
 * view user information controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsServiceCategories;

class ViewInformationController extends Controller
{
    use NeedsServiceCategories;

    /**
     * handle incoming request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle() : View
    {
        // get escort info
        $escort = $this->repository->find($this->request->get('id'));

        // combinde languages
        $languagesDesc = $escort->escortLanguages->transform(function ($language) {
            return $language->attribute->getDescription(app()->getLocale())->content;
        })->implode(',');

        // combined service categories
        $categoriesDesc = $this->getServiceCategories()->transform(function ($category) use ($escort) {
            return ($category->isEscortAllowed($escort))
                ? $category->getDescription(app()->getLocale())->content
                : null;
        })->filter(function ($desc) {
            return (! empty($desc));
        })->implode(',');

        // create view instance
        return view('Admin::escorts.view_info', [
            'escort' => $escort,
            'categoriesDesc' => (! empty($categoriesDesc)) ? $categoriesDesc : null,
            'languageDesc' => (! empty($languagesDesc)) ? $languagesDesc : null
        ]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:escorts.manage');
    }
}
