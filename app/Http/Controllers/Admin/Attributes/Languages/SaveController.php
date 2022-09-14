<?php
/**
 * saves which creates/updates attribute information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Attributes\Languages;

use App\Models\Attribute;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\AttributeDescriptionRepository;

class SaveController extends Controller
{
    /**
     * handles incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $attribute = null;

        if ($id = $this->request->input('id')) {
            $attribute = $this->repository->find($id);

            if (! $attribute) {
                $this->notifyError(__('Requested attribute does not exists'));
                return redirect()->route('admin.attribute.languages.create');
            }
        }

        // validate request
        $this->validateRequests();

        // save request
        $attribute = $this->saveAttribute($attribute);

        // notify
        $this->notifySuccess(__('Data successfully saved'));

        return $this->redirectTo($attribute);
    }

    /**
     * validates incoming request
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequests() : void
    {
        $this->validate(
            $this->request,
            [
                'descriptions.*' => 'required',
                'attribute.is_active' => 'boolean'
            ]
        );
    }

    /**
     * save attribute
     *
     * @param  App\Models\Attribute|null $attribute
     *
     * @return App\Models\Attribute
     */
    protected function saveAttribute(Attribute $attribute = null) : Attribute
    {
        // setup attributes
        $attributes = [
            'is_active' => $this->request->input('attribute.is_active'),
            'name'      => (! is_null($attribute)) ? $attribute->name : static::LANGUAGES_ATTRIBUTE_NAME,
        ];

        // save model instance
        $attribute = $this->repository->save($attributes, $attribute);

        foreach ($this->request->input('descriptions') as $code => $content) {
            // setup attributes
            $attributes = [
                'content' => $content,
                'lang_code' => $code,
            ];

            // get description instance from attribute model
            $description = $attribute->getDescription($code, false);

            // save model instance
            $this->getAttributeDescriptionRepository()->saveDescription($attributes, $attribute, $description);
        }

        return $attribute;
    }

    /**
     * repository instance of App\Repository\AttributeDescriptionRepository
     *
     * @return App\Repository\AttributeDescriptionRepository
     */
    protected function getAttributeDescriptionRepository() : AttributeDescriptionRepository
    {
        return app(AttributeDescriptionRepository::class);
    }

    /**
     * redirects to next request
     *
     * @param  App\Models\Attribute $attribute
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Attribute $attribute) : RedirectResponse
    {
        return redirect()->route('admin.attribute.languages.update', ['id' => $attribute->getKey()]);
    }
}
