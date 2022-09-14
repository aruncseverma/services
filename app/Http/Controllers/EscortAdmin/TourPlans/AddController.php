<?php
/**
 * controller class for creating tour plan
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\TourPlans;

use App\Models\Escort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\TourPlanRepository;

class AddController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $user = $this->getAuthUser();
        if (! $user) {
            $this->notifyError(__('User not found.'));
            return redirect()->back();
        }

        // validate request if passed then proceeds to saving user info
        $this->validateRequest($user);

        // save data
        $user = $this->saveData($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully saved.'));
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }

        return $this->redirectTo($user);
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\Escort|null $user
     *
     * @return void
     */
    protected function validateRequest(Escort $user = null) : void
    {
        $rules = [
            'continent_id' => ['required'],
            'country_id'  => ['required'],
            'state_id' => ['required'],
            'city_id' => ['required'],
            'date_start' => ['required'],
            'date_end' => ['required'],
            'telephone' => ['required'],
            'phone_instructions' => ['required'],
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules
        );
    }

    /**
     * save data
     *
     * @param  App\Models\Escort|null $user
     *
     * @return App\Models\Escort
     */
    protected function saveData(Escort $user = null) : Escort
    {
        $repository = app(TourPlanRepository::class);

        // save it
        $repository->store(
            [
                'continent_id' => $this->request->input('continent_id'),
                'country_id' => $this->request->input('country_id'),
                'state_id' => $this->request->input('state_id'),
                'city_id' => $this->request->input('city_id'),
                'date_start' => $this->request->input('date_start'),
                'date_end' => $this->request->input('date_end'),
                'telephone' => $this->request->input('telephone'),
                'phone_instructions' => $this->request->input('phone_instructions'),
            ],
            $user
        );

        return $user;
    }

    /**
     * redirect to next route
     *
     * @param  App\Models\Escort $user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Escort $user) : RedirectResponse
    {
        return redirect()->route('escort_admin.tour_plans');
    }
}
