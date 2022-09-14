<?php
/**
 * save language controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Languages;

use App\Models\Language;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsLanguages;

class SaveController extends Controller
{
    use NeedsLanguages;

    /**
     * handles incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $language = null;
        if ($id = $this->request->input('id')) {
            // get language model
            $language = $this->repository->find($id);

            if (! $language) {
                $this->notifyError(__('Language requested does not exists'));
                return redirect()->back();
            }
        }

        // validate incoming request
        $this->validateRequests($language);

        // save request
        $language = $this->saveLanguage($language);

        $this->notifySuccess(__('Data successfully saved'));

        // clear cache
        $this->forgetLanguagesCache();

        // redirect
        return $this->redirectTo($language);
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\Language|null $language
     *
     * @return void
     */
    protected function validateRequests(Language $language = null) : void
    {
        $rules = [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:4'],
            'is_active' => 'boolean'
        ];

        // create unique rule
        $unique = Rule::unique($this->repository->getTable());

        if (! is_null($language)) {
            // ignore current model
            $unique->ignoreModel($language);
        }

        // add rule
        $rules['code'][] = $unique;
        $rules['country_id'][] = Rule::exists(
            $this->getCountryRepository()->getTable(),
            $this->getCountryRepository()->getModel()->getKeyName()
        );

        $this->validate(
            $this->request,
            $rules
        );
    }

    /**
     * save language data
     *
     * @param  App\Models\Language $language
     *
     * @return App\Models\Language
     */
    protected function saveLanguage(Language $language = null) : Language
    {
        $attributes = [
            'name' => $this->request->input('name'),
            'code' => $this->request->input('code'),
            'is_active' => $this->request->input('is_active'),
        ];

        // get country model
        $country = $this->getCountryRepository()->find($this->request->input('country_id'));

        return $this->repository->store($attributes, $country, $language);
    }

    /**
     * redirect to next request
     *
     * @param  App\Models\Language $language
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Language $language) : RedirectResponse
    {
        return redirect()->route('admin.language.update', ['id' => $language->getKey()]);
    }
}
