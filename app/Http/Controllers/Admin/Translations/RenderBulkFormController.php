<?php

namespace App\Http\Controllers\Admin\Translations;

use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsLanguages;

class RenderBulkFormController extends Controller
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

        $translations = old('trans', []);
        // set necessary title for this form
        $this->setTitle(__('New Translations'));

        return view('Admin::translations.bulk_form', [
            'translations' => $translations,
            'languages' => $languages,
            'langCode' => $langCode,
        ]);
    }
}
