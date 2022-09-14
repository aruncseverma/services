<?php

namespace App\Http\Controllers\Admin\Members;

use App\Models\Member;
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
        $this->setTitle(($user->getKey()) ? __('Update Member') : __('New Member'));

        // get type from request or user
        $type = ($user->getKey()) ? $user->type : self::DEFAULT_TYPE;

        if (! $type) {
            return redirect()->route('admin.member.create');
        }

        // create view instance
        $view = view(
            'Admin::members.form',
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
     * @return App\Models\Member
     */
    protected function getUser() : Member
    {
        $user = null;
        if ($id = $this->request->get('id')) {
            $user = $this->repository->find($id);
            if (! $user) {
                $this->notifyError(__('Requested user not found.'));
                throw new HttpResponseException(redirect()->route('admin.member.create'));
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
    protected function populateModelFromOldInput() : Member
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
            $this->middleware('can:members.update');
        } else {
            $this->middleware('can:members.create');
        }
    }
}
