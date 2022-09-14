<?php
/**
 * controller class for rendering administrator form
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Administrators;

use App\Models\Administrator;
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
        $user = $this->getUser();

        // set title
        $this->setTitle(($user->getKey()) ? __('Update Administrator') : __('New Administrator'));

        // get type from request or user
        $type = ($user->getKey()) ? $user->type : self::DEFAULT_TYPE;

        if (! $type) {
            return redirect()->route('admin.administrator.create');
        }

        if ($user->getKey() == config('app.super_admin_user_id') && !$this->isSuperAdmin()) {
            $this->notifyError(__('Permission Denied.'));
            return redirect()->route('admin.administrators.manage');
        }

        // create view instance
        $view = view(
            'Admin::administrators.form',
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
     * @return App\Models\Administrator
     */
    protected function getUser() : Administrator
    {
        $user = null;
        if ($id = $this->request->get('id')) {
            $user = $this->repository->find($id);
            if (! $user) {
                $this->notifyError(__('Requested user not found.'));
                throw new HttpResponseException(redirect()->route('admin.administrator.create'));
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
    protected function populateModelFromOldInput() : Administrator
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
            $this->middleware('can:administrators.update');
        } else {
            $this->middleware('can:administrators.create');
        }
    }
}
