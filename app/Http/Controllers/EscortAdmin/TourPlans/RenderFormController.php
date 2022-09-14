<?php
/**
 * controller class for rendering Tour Plan form
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\TourPlans;

use App\Models\Escort;
use App\Repository\TourPlanRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;

class RenderFormController extends Controller
{
    /**
     * create view instance
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view()
    {
        $user = $this->getAuthUser();
        // set title
        $this->setTitle(__('Tour Plan'));

        $tourPlanData = '';
        $id = $this->request->input('id');
        // get tour plan data only if request is not come from validation
        if (old('id') == null && !empty($id)) {
            $repository = app(TourPlanRepository::class);
            $tourPlanData = $repository->findTourPlanById($id, $user);
            if (! $tourPlanData) {
                $this->notifyError(__('Requested tour plan not found.'));
            }
        }

        // create view instance
        $view = view(
            'EscortAdmin::tour_plans.form',
            [
                'user' => $user,
                'id' => $id,
                'tourPlanData'  => $tourPlanData,
            ]
        );

        return $view;
    }
}
