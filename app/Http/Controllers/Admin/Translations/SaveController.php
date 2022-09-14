<?php

namespace App\Http\Controllers\Admin\Translations;

use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsLanguages;
use Illuminate\Validation\Rule;

class SaveController extends Controller
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

        if ($id = $request->input('id')) {
            // get translation requested from repository
            $translation = $this->repository->find($id);

            if (!$translation) {
                $this->notifyError(__('Requested translation is invalid'));
                return back();
            }
        }

        // validate
        $this->validateRequest($request, $translation);

        // push to repository
        $translation = $this->saveTranslation($request, $translation);

        // redirect to next request
        return $this->redirectTo($translation, $request);
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
            'translation.group' => ['required'],
            'translation.key'   => ['required'],
            'translation.text.*' => ['required', 'max:255'],
        ];

        $customAttributes = [
            'translation.group' => 'Group',
            'translation.key'   => 'Key',
        ];

        $languages = $this->getLanguages();
        foreach ($languages as $language) {
            $customAttributes['translation.text.' . $language->code] = $language->name;
        }

        $group = $request->input('translation.group');
        $uniqueKey = Rule::unique($this->repository->getTable(), 'key')
            ->where(function ($query) use ($group) {
                return $query->where('group', $group);
            });

        // append additional rules
        if (!is_null($translation)) {
            // appends ignore current model to be updated
            $uniqueKey->ignoreModel($translation);
        }

        $rules['translation.key'][] = $uniqueKey;

        $this->validate(
            $request,
            $rules,
            [],
            $customAttributes
        );
    }

    /**
     * save translation to repository
     *
     * @param  Illuminate\Http\Request $request
     * @param  LanguageLine $translation
     *
     * @return null|LanguageLine
     */
    protected function saveTranslation(Request $request, LanguageLine $translation = null)
    {
        $attributes = [
            'group' => $request->input('translation.group'),
            'key' => $request->input('translation.key'),
            'text' => $request->input('translation.text'),
        ];

        // save translation to the repository
        $translation = $this->repository->store($attributes, $translation);

        if (!$translation) {
            return;
        }

        return $translation;
    }

    /**
     * redirect to next request
     *
     * @param  LanguageLine $translation
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(LanguageLine $translation = null, Request $request): RedirectResponse
    {
        if (is_null($translation)) {
            $this->notifyError(__('Unable to save your request. Please try again sometime'));
        } else {
            $this->notifySuccess(__('Translation successfully saved'));
        }

        return redirect()->route('admin.translation.update', ['id' => $translation->getKey()]);
    }
}
