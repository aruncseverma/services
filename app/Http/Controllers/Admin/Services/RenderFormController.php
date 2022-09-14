<?php
/**
 * controller class for rendering service form
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Support\Concerns\NeedsLanguages;
use App\Support\Concerns\NeedsServiceCategories;

class RenderFormController extends Controller
{
    use NeedsLanguages,
        NeedsServiceCategories;

    /**
     * renders the view form
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     *         Illuminate\Contracts\View\View
     */
    public function view(Request $request)
    {
        $service = $this->getModelFromOldRequest();

        // get service by using id
        if ($id = $request->get('id')) {
            $service = $this->repository->find($id);
            if (! $service) {
                $this->notifyError(__('Service request does not exits'));
                return redirect()->route('admin.services.create');
            }
        }

        // set title
        $this->setTitle(
            ($service->getKey()) ? __('Update Service') : __('Create Service')
        );

        // render view
        return view('Admin::services.form', [
            'service' => $service,
            'languages' => $this->getLanguages(),
            'categories' => $this->getServiceCategories(),
        ]);
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\Service
     */
    protected function getModelFromOldRequest() : Service
    {
        $service = $this->repository->getModel();

        // set service info
        foreach (old('duration', []) as $key => $value) {
            $duration->setAttribute($key, $value);
        }

        // get descriptions
        foreach (old('descriptions', []) as $code => $value) {
            // get new model instance
            $description = $service->descriptions()->getModel();
            $description->setAttribute('lang_code', $code);
            $description->setAttribute('content', $value);

            // append to collection
            $service->descriptions->add($description);
        }

        return $service;
    }
}
