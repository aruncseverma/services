<?php

namespace App\Http\Controllers\Admin\Translations;

use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsLanguages;

class RenderFormController extends Controller
{
    use NeedsLanguages;

    /**
     * renders form view
     *
     * @param  Illuminate\Http\Request
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view(Request $request)
    {
        $langCode = $request->input('lang_code', app()->getLocale());
        $languages = $this->getLanguages();

        $id = old('id', $request->get('id'));

        // requested translation data
        if (empty(old()) && $id) {
            // try fetching the translation model from the repository
            $translation = $this->repository->find($id);

            if (!$translation) {
                $this->notifyError(__('Requested data not found'));
                return redirect()->route('admin.translation.create');
            }

        } else {
            // get translation model from old input if necessary
            $translation = $this->getModelFromOldRequest();
        }

        // set necessary title for this form
        $this->setTitle(
            ($translation->getKey()) ? __('Update Translation') : __('New Translation')
        );

        return view('Admin::translations.form', [
            'translation' => $translation,
            'languages' => $languages,
            'langCode' => $langCode,
        ]);
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\LanguageLine
     */
    protected function getModelFromOldRequest() : LanguageLine
    {
        $translation = $this->repository->getModel();

        // set translation info
        foreach (old('translation', []) as $key => $value) {
            $translation->setAttribute($key, $value);
        }

        return $translation;
    }
}
