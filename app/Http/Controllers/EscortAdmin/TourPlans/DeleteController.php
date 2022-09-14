<?php
/**
 * controller class for deleting tour plan
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\TourPlans;

use App\Models\Escort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\TourPlanRepository;

class DeleteController extends Controller
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

        // process delete
        $result = $this->deleteData($user);

        // notify next request
        if ($result) {
            $this->notifySuccess(__('Delete success.'));
        } else {
            $this->notifyWarning(__('Unable to delete user. Please try again later'));
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
            $this->notifyError(__('Delete requires identifier.'));
            redirect()->back();
        }
    }

    /**
     * delete data
     *
     * @param  App\Models\Escort|null $user
     *
     * @return boolean
     */
    protected function deleteData(Escort $user = null) : bool
    {
        $repository = app(TourPlanRepository::class);

        $id = $this->request->input('id');

        // gets previously set
        $data = $repository->findTourPlanById($id, $user);

        // if has model set delete that
        if ($data) {
            return $repository->delete($data->getKey());
        }

        return false;
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
