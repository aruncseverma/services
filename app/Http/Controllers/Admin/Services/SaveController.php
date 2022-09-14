<?php
/**
 * controller class for saving escort service information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsLanguages;
use App\Repository\ServiceDescriptionRepository;
use App\Support\Concerns\NeedsServiceCategories;

class SaveController extends Controller
{
    use NeedsServiceCategories,
        NeedsLanguages;

    /**
     * handle incoming request data
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $service = null;
        if ($id = $request->input('id')) {
            if (! $service = $this->repository->find($id)) {
                $this->notifyError(__('Service requested doest not exists'));
                return back();
            }
        }

        // validate
        $this->validateRequest($request);

        // save service information
        $service = $this->saveService($request->input('service'), $request->input('descriptions'), $service);

        // notify
        $this->notifySuccess(__('Data saved successfully'));

        // clear cache
        $this->forgetServiceCategoryCache();

        return redirect()->route('admin.service.update', ['id' => $service->getKey()]);
    }

    /**
     * validates incoming request data
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'service' => 'array',
                'service.position' => 'numeric',
                'descriptions'   => 'array',
                'descriptions.*' => 'required',
                'service.is_active' => 'boolean',
                'service.service_category_id' => [
                    'required',
                    Rule::exists($this->getServiceCategoryRepository()->getTable(), 'id')->where(function ($query) {
                        $query->where('is_active', true);
                    })
                ],
            ]
        );
    }

    /**
     * save service information
     *
     * @param  array              $info
     * @param  array              $descriptions
     * @param  App\Models\Service $service
     *
     * @return App\Models\Service
     */
    protected function saveService(array $info, array $descriptions, Service $service = null) : Service
    {
        $attributes = [
            'is_active' => (isset($info['is_active'])) ? true : false,
            'position' => (isset($info['position'])) ? $info['position'] : 0,
        ];

        // get category for this service
        $category = $this->getServiceCategoryRepository()->find($info['service_category_id']);

        // save duration to the repository
        $service = $this->repository->store($attributes, $category, $service);

        foreach ($this->getLanguages() as $language) {
            // check if requested then save
            if (isset($descriptions[$language->code])) {
                app(ServiceDescriptionRepository::class)->store(
                    [
                        'content' => $descriptions[$language->code]
                    ],
                    $language,
                    $service,
                    $service->getDescription($language->code, false)
                );
            }
        }

        return $service;
    }
}
