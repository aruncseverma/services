<?php
/**
 * controller class for rendering form
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services\Categories;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Repository\CityRepository;
use App\Repository\StateRepository;
use Illuminate\Contracts\View\View;
use App\Repository\CountryRepository;
use App\Support\Concerns\NeedsLanguages;

class RenderFormController extends Controller
{
    use NeedsLanguages;

    /**
     * render view form
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view(Request $request)
    {
        // look for the requested category
        $category = $this->getModelFromOldRequest();

        if ($id = $request->get('id')) {
            $category = $this->repository->find($id);

            if (! $category) {
                $this->notifyError(__('Service category requested not found'));
                return redirect()->route('escort_admin.services.category.create');
            }
        }

        $this->setTitle(
            ($category->getKey()) ? __('Update Service Category') : __('Create Service Category')
        );

        return view('Admin::services.categories.form', [
            'category' => $category,
            'languages' => $this->getLanguages(),
            'selectedLocations' => $this->createJsonFromSelectedLocations($category),
        ]);
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\ServiceCategory
     */
    protected function getModelFromOldRequest() : ServiceCategory
    {
        $category = $this->repository->getModel();

        // set duration info
        foreach (old('category', []) as $name => $value) {
            if (is_array($value) && $name == 'ban_locations') {
                foreach ($value as $key => $val) {
                    $value[$key] = explode(',', $val);
                }
            }
            $category->setAttribute($name, $value);
        }

        // get descriptions
        foreach (old('descriptions', []) as $code => $value) {
            // get new model instance
            $description = $category->descriptions()->getModel();
            $description->setAttribute('lang_code', $code);
            $description->setAttribute('content', $value);

            // append to collection
            $category->descriptions->add($description);
        }

        return $category;
    }

    protected function createJsonFromSelectedLocations(ServiceCategory $category) : string
    {
        $cityRepository = app(CityRepository::class);
        $countryRepository = app(CountryRepository::class);
        $stateRepository = app(StateRepository::class);

        $data = [];

        // loop each group
        foreach (['countries', 'states', 'cities'] as $group) {
            foreach ($category->getBanLocationsByGroup($group) as $selected) {
                $model = null;
                switch (strtolower($group)) {
                    case 'countries':
                        $model = $countryRepository->find($selected);
                        break;
                    case 'states':
                        $model = $stateRepository->find($selected);
                        break;
                    case 'cities':
                        $model = $cityRepository->find($selected);
                        break;
                }

                if ($model) {
                    $data[] = [
                        'group' => $group,
                        'label' => $model->name,
                        'id' => $model->getKey(),
                    ];
                }
            }
        }

        return json_encode($data);
    }
}
