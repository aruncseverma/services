<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use App\Models\Escort;
use App\Models\EscortService;
use App\Repository\ServiceCategoryRepository;
use App\Repository\ServiceRepository;
use App\Repository\EscortServiceRepository;

trait GenerateUserServices
{
    /**
     * get service types options
     *
     * @return array
     */
    private function getServiceTypes(): array
    {
        return [
            EscortService::TYPE_STANDARD => __('Standard'),
            EscortService::TYPE_EXTRA => __('Extra'),
            EscortService::TYPE_NOT => __('Not')
        ];
    }

    /**
     * Generate user services
     * 
     * @return array
     */
    private function generateUserServices()
    {
        $services = [];
        $repo = app(ServiceCategoryRepository::class);
        $serviceCategories = $repo->getBuilder()->select('id')
            ->where('is_active', true)
            ->get();
        $serviceCatIds = [];
        if (!empty($serviceCategories)) {
            foreach ($serviceCategories as $cat) {
                $serviceCatIds[] = $cat->id;
            }

            $repo = app(ServiceRepository::class);
            $services = $repo->getBuilder()->select('id')
                ->where('is_active', true)
                ->whereIn('service_category_id', $serviceCatIds)
                ->get();
        }

        $escortServices = [];
        if (!empty($services)) {
            foreach ($services as $service) {
                $escortServices[] = [
                    'service_id' => $service->id,
                    'type' => $this->getRandomValue(array_keys($this->getServiceTypes())),
                ];
            }
        }

        return $escortServices;
    }

    /**
     * save user services
     *
     * @param  App\Models\Escort $user
     * @param array $userServices
     *
     * @return void
     */
    private function saveUserServices(Escort $user, $userServices): void
    {
        $repository = app(EscortServiceRepository::class);
        foreach ($userServices as $data) {
            $data['user_id'] = $user->getKey();
            $repository->save($data);
        }
    }
}