<?php
/**
 * controller class for updating current escort services
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Services;

use App\Models\Escort;
use Illuminate\Http\Request;
use App\Models\EscortService;
use Illuminate\Validation\Rule;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use App\Repository\EscortServiceRepository;

class UpdateServicesController extends Controller
{
    /**
     * create instance
     *
     * @param App\Repository\EscortServiceRepository $repository
     */
    public function __construct(EscortServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * handles incoming request
     *
     * @param  App\Models\ServiceCategory $category
     * @param  Illuminate\Http\Request    $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(ServiceCategory $category, Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        // bind requested services to the escort
        $this->bindServices($request->input('services', []), $category, $this->getAuthUser());

        // notify
        $this->notifySuccess(__('Services saved successfully'));

        $this->removeEscortFilterCache([
            'escort_service_ids',
            'erotic_service_ids',
            'extra_service_ids',
            'fetish_service_ids',
        ]);
        return back()->withInput(['notify' => 'services.' . $category->getKey()]);
    }

    /**
     * validates incoming request data
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
                'services' => 'array',
                'services.*' => [
                    'required',
                    Rule::in(EscortService::ALLOWED_TYPES),
                ]
            ]
        );
    }

    /**
     * bind services to escort
     *
     * @param array                      $services
     * @param App\Models\ServiceCategory $category
     * @param App\Models\Escort          $escort
     */
    protected function bindServices(array $services, ServiceCategory $category, Escort $escort) : void
    {
        foreach ($category->services as $service) {
            if (in_array($service->getKey(), array_keys($services))) {
                $this->repository->store(
                    [
                        'type' => $services[$service->getKey()]
                    ],
                    $escort,
                    $service,
                    $escort->getService($service->getKey())
                );
            }
        }
    }
}
