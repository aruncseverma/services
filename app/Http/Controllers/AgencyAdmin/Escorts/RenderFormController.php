<?php
/**
 * controller class for rendering Escort form
 *
 * 
 */

namespace App\Http\Controllers\AgencyAdmin\Escorts;

use App\Models\Escort;
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
        $agency = $this->getAuthUser();
        $user = $this->getUser();

        // if current agency of the selected escort does not matched with the current
        // authenticated agency
        if ($user->getKey() && (empty($user->agency) || $agency->getKey() != $user->agency->getKey())) {
            $this->notifyError(__('Escort does not belong to your agency'));
            return redirect()->route('agency_admin.escorts');
        }

        // set title
        $this->setTitle(($user->getKey()) ? __('Update Escort') : __('New Escort'));

        // get type from request or user
        $type = ($user->getKey()) ? $user->type : self::DEFAULT_TYPE;

        if (! $type) {
            return redirect()->route('agency_admin.escort.create');
        }

        // create view instance
        $view = view(
            'AgencyAdmin::escorts.form',
            [
                'type'  => $type,
                'user'  => $user,
            ]
        );

        return $view;
    }

    /**
     * get user model
     *
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     *
     * @return App\Models\Escort
     */
    protected function getUser() : Escort
    {
        $user = null;
        if ($id = $this->request->get('id')) {
            $user = $this->repository->findUserByUsername($id);
            if (! $user) {
                $this->notifyError(__('Requested user not found.'));
                throw new HttpResponseException(redirect()->route('agency_admin.escort.create'));
            }
        } else {
            $user = $this->populateModelFromOldInput();
        }

        return $user;
    }

    /**
     * populate model from old input request
     *
     * @return App\Models\User
     */
    protected function populateModelFromOldInput() : Escort
    {
        $user = $this->repository->getModel();

        // get all input
        foreach (old(null, []) as $key => $value) {
            $user->setAttribute($key, $value);
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        if ($this->request->has('id')) {
            //$this->middleware('can:escorts.update');
        } else {
            $this->middleware('can:escorts.create');
        }
    }
}
