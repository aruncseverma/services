<?php
/**
 * controller class for updating tour plan
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\TourPlans;

use App\Models\Escort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\TourPlanRepository;

class UpdateController extends Controller
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

        // update data
        $user = $this->updateData($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully updated.'));
        } else {
            $this->notifyWarning(__('Unable to update current request. Please try again sometime'));
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
        // notify and redirect if does not have any identifier
        if (! $this->request->input('id')) {
            $this->notifyError(__('Update requires identifier.'));
            redirect()->back();
        }

        $rules = [
            'edit_continent_id' => ['required'],
            'edit_country_id'  => ['required'],
            'edit_state_id' => ['required'],
            'edit_city_id' => ['required'],
            'edit_date_start' => ['required'],
            'edit_date_end' => ['required'],
            'edit_telephone' => ['required'],
            'edit_phone_instructions' => ['required'],
        ];

        $messages = [
            'edit_continent_id.required' => __('validation.required', ['attribute' => 'Continent']),
            'edit_country_id.required'  => __('validation.required', ['attribute' => 'Country']),
            'edit_state_id.required' => __('validation.required', ['attribute' => 'State']),
            'edit_city_id.required' => __('validation.required', ['attribute' => 'City']),
            'edit_date_start.required' => __('validation.required', ['attribute' => 'Date Start']),
            'edit_date_end.required' => __('validation.required', ['attribute' => 'Date End']),
            'edit_telephone.required' => __('validation.required', ['attribute' => 'Telephone']),
            'edit_phone_instructions.required' => __('validation.required', ['attribute' => 'Phone Instructions']),
        ];


        // validate request
        $this->validate(
            $this->request,
            $rules,
            $messages
        );
    }

    /**
     * save data
     *
     * @param  App\Models\Escort|null $user
     *
     * @return App\Models\Escort
     */
    protected function updateData(Escort $user = null) : Escort
    {
        $repository = app(TourPlanRepository::class);

        $id = $this->request->input('id');

        // gets previously set
        $data = $repository->findTourPlanById($id, $user);

        // save it
        $repository->store(
            [
                'continent_id' => $this->request->input('edit_continent_id'),
                'country_id' => $this->request->input('edit_country_id'),
                'state_id' => $this->request->input('edit_state_id'),
                'city_id' => $this->request->input('edit_city_id'),
                'date_start' => $this->request->input('edit_date_start'),
                'date_end' => $this->request->input('edit_date_end'),
                'telephone' => $this->request->input('edit_telephone'),
                'phone_instructions' => $this->request->input('edit_phone_instructions'),
            ],
            $user,
            $data
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
        return redirect()->route(
            'escort_admin.tour_plans',
            [
                'id' => $this->request->input('id')
            ]
        );
    }
}
