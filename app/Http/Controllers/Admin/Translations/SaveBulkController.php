<?php

namespace App\Http\Controllers\Admin\Translations;

use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsLanguages;
use Illuminate\Validation\Rule;

class SaveBulkController extends Controller
{
    use NeedsLanguages;

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $translation = null;

        $trans = $request->input('trans');
        if (empty($trans)) {
            $this->notifyError(__('No data to save'));
            return redirect()->back();
        }

        // validate
        $this->validateRequest($request, $translation);

        // push to repository
        $translations = $this->saveTranslations($request);

        // redirect to next request
        return $this->redirectTo($translations, $request);
    }

    /**
     * validates incoming request data
     *
     * @param  Illuminate\Http\Request $request
     * @param  LanguageLine $translation
     * 
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest(Request $request, LanguageLine $translation = null): void
    {
        $rules = [
            'trans.*.group' => ['required'],
            'trans.*.key'   => ['required'],
            'trans.*.text.*' => ['required', 'max:255'],
        ];

        $customAttributes = [
            'trans.*.group' => 'Group',
            'trans.*.key'   => 'Key',
            'trans.*.text.*'   => 'Text',
        ];

        $languages = $this->getLanguages();
        foreach ($languages as $language) {
            $customAttributes['trans.*.text.' . $language->code] = $language->name; // its not working
        }

        $trans = $request->input('trans');
        if (!empty($trans)) {
            foreach ($trans as $k => $tran) {
                $group = $tran['group'];
                $uniqueKey = Rule::unique($this->repository->getTable(), 'key')
                ->where(function ($query) use ($group) {
                    return $query->where('group', $group);
                });

                //$rules['trans.' . $k . '.key'][] = $uniqueKey;
                $rules['trans.' . $k . '.key'] = ['required', $uniqueKey];
            }
        }

        $this->validate(
            $request,
            $rules,
            [],
            $customAttributes
        );
    }

    /**
     * save translations to repository
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function saveTranslations(Request $request)
    {
        $trans = $request->input('trans');
        $translations = [];
        if (!empty($trans)) {
            foreach($trans as $attributes) {
                // save translation to the repository
                $translation = $this->repository->store($attributes);
                if ($translation) {
                    $translations[] = $translation;
                }
            }
        }
        return $translations;
    }

    /**
     * redirect to next request
     *
     * @param  array $translations
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(array $translations = [], Request $request): RedirectResponse
    {
        if (empty($translations)) {
            $this->notifyError(__('Unable to save your request. Please try again sometime'));
        } else {
            $this->notifySuccess(__('Translation(s) successfully saved'));
        }

        return redirect()->route('admin.translations.manage');
    }
}
