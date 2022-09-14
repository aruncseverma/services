<?php
/**
 * render attribute form controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Attributes\Physical;

use App\Models\Attribute;
use App\Support\Concerns\NeedsLanguages;

class RenderFormController extends Controller
{
    use NeedsLanguages;

    /**
     * renders the form view
     *
     * @param  string $name
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view($name = self::FALLBACK_ATTRIBUTE_NAME)
    {
        $attribute = $this->getModelFromOldRequest();

        if ($id = $this->request->get('id')) {
            $attribute = $this->repository->find($id);

            if (! $attribute) {
                $this->notifyError(__('Attribute requested does not exists'));
                return redirect()->route('admin.attribute.create');
            }

            // replace requested with name
            $name = $attribute->name;
        }

        $this->setTitle(
            ($attribute->getKey()) ? __('Update Attribute') : __('Create Attribute')
        );

        // create view instance
        return view('Admin::attributes.physical.form', [
            'attribute' => $attribute,
            'name'      => $name,
            'languages' => $this->getLanguages(),
        ]);
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\Attribute
     */
    protected function getModelFromOldRequest() : Attribute
    {
        $attribute = $this->repository->getModel();

        // set attribute info
        foreach (old('attribute', []) as $key => $value) {
            $attribute->setAttribute($key, $value);
        }

        // get descriptions
        foreach (old('descriptions', []) as $code => $value) {
            // get new model instance
            // then set attributes
            $description = $attribute->descriptions()->getModel();
            $description->setAttribute('lang_code', $code);
            $description->setAttribute('content', $value);

            // append to collection
            $attribute->descriptions->add($description);
        }

        return $attribute;
    }
}
