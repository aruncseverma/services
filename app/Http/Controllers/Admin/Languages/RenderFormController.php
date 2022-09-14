<?php
/**
 * renders language form controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Languages;

use App\Models\Language;
use Illuminate\Contracts\View\View;

class RenderFormController extends Controller
{
    /**
     * renders language form
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view()
    {
        $language = $this->fillFromOldRequest();

        // get language model from request
        if ($id = $this->request->get('id')) {
            $language = $this->repository->find($id);
            if (! $language) {
                $this->notifyError(__('Language requested does not exists'));
                return redirect()->route('admin.language.create');
            }
        }

        // set page title
        $this->setTitle(
            ($language->getKey()) ? __('Update Language') : __('Create Language')
        );

        return view(
            'Admin::languages.form',
            [
                'language' => $language
            ]
        );
    }

    /**
     * get model attributes from old request input
     *
     * @return App\Models\Language
     */
    protected function fillFromOldRequest() : Language
    {
        $language = $this->repository->getModel();

        // set attribute
        foreach (old() as $key => $value) {
            $language->setAttribute($key, $value ?: '');
        }

        return $language;
    }
}
