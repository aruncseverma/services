<?php
/**
 * controller class for saving categories information
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Services\Categories;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsLanguages;
use App\Repository\ServiceCategoryRepository;
use App\Support\Concerns\NeedsServiceCategories;
use App\Repository\ServiceCategoryDescriptionRepository;

class SaveController extends Controller
{
    use NeedsLanguages,
        NeedsServiceCategories;

    /**
     * instance of service category repository
     *
     * @var App\Repository\ServiceCategoryDescriptionRepository
     */
    protected $descriptionRepository;

    /**
     * create instance
     *
     * @param App\Repository\ServiceCategoryRepository            $repository
     * @param App\Repository\ServiceCategoryDescriptionRepository $descriptionRepository
     */
    public function __construct(ServiceCategoryRepository $repository, ServiceCategoryDescriptionRepository $descriptionRepository)
    {
        $this->repository = $repository;
        $this->descriptionRepository = $descriptionRepository;

        parent::__construct($repository);
    }

    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $category = null;
        if ($id = $request->input('id')) {
            $category = $this->repository->find($id);

            if (! $category) {
                $this->notifyError(__('Service category requested not found'));
                return back();
            }
        }

        // save category
        $category = $this->saveCategory($request->input('descriptions', []), $request->input('category', []), $category);

        return $this->redirectTo($category);
    }

    /**
     * validate incoming request data
     *
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
                'category' => 'array',
                'descriptions' => 'array',
                'descriptions.*' => 'required',
                'category.is_active' => 'boolean',
            ]
        );
    }

    /**
     * save category information
     *
     * @param  array                       $descriptionsData
     * @param  array                       $categoryData
     * @param  App\Service\ServiceCategory $category
     *
     * @return App\Service\ServiceCategory
     */
    protected function saveCategory(array $descriptionsData, array $categoryData, ServiceCategory $category = null) : ServiceCategory
    {
        $category = $this->repository->save(
            [
                'is_active' => (isset($categoryData['is_active'])) ? $categoryData['is_active'] : false,
                'position' => (isset($categoryData['position'])) ? $categoryData['position'] : 0,
                'ban_locations' => $this->parseLocationsToArray($categoryData['ban_locations']),
            ],
            $category
        );

        // save descriptions
        foreach ($this->getLanguages() as $language) {
            if (isset($descriptionsData[$language->code])) {
                $this->descriptionRepository->store(
                    [
                        'content' => $descriptionsData[$language->code],
                    ],
                    $category,
                    $language,
                    $category->getDescription($language->code, false)
                );
            }
        }

        return $category;
    }

    /**
     * parse given locations to array
     *
     * @param  array $locations
     *
     * @return void
     */
    protected function parseLocationsToArray(array $locations) : array
    {
        array_walk($locations, function (&$location) {
            $location = explode(',', $location);
        });

        return array_merge(
            [
                'country_ids' => [],
                'state_ids' => [],
                'city_ids' => []
            ],
            $locations
        );
    }

    /**
     * redirects to next request
     *
     * @param  App\Models\ServiceCategory $category
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(ServiceCategory $category) : RedirectResponse
    {
        if ($category->getKey()) {
            $this->notifySuccess(__('Data saved successfully'));

            // clear cache
            $this->forgetServiceCategoryCache();

            return redirect()->route('admin.services.categories.update', ['id' => $category->getKey()]);
        }

        $this->notifyError(__('Unable to save data. Please try again sometime'));

        return back();
    }
}
