<?php
/**
 * controller class handles changes from permissions through manage page of permissions
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Permissions;

use Illuminate\Http\RedirectResponse;

class SaveController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $this->validatesRequests();

        // get defined role if requested
        $role = null;
        if (($id = $this->request->input('id')) && $id !== 'new') {
            $role = $this->repository->find($id);
            if (! $role) {
                $this->notifyError(__('Requested role does not exists or invalid'));
                return redirect()->back()->withInput();
            }
        }

        // attributes
        $attributes = [
            'permissions' => $this->request->input('permissions', []),
            'group' => $this->request->input('group'),
        ];

        // save
        $role = $this->repository->save($attributes, $role);

        // notify
        $this->notifySuccess(__('Role saved successfully'));

        // redirect to next request
        return redirect()->route('admin.permissions.manage', ['id' => $role->getKey()]);
    }

    /**
     * validates incoming requests
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validatesRequests() : void
    {
        $this->validate(
            $this->request,
            [
                'id' => 'required',
                //'group' => 'required_if:id,new',
                'group' => 'required',
            ]
        );
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:roles.manage');
    }
}
