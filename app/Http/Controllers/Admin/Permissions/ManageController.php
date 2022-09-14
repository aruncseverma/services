<?php
/**
 * controller class for managing permissions and roles
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Permissions;

use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Support\Permissions\Permission;

class ManageController extends Controller
{
    /**
     * renders permisions and roles form
     *
     * @return View
     */
    public function index() : View
    {
        $this->setTitle(__('Manage Roles and Permissions'));

        // get role model default:: from old input
        $role = $this->getRoleModelFromOldInput();

        $roles = $this->repository->findAll([]);
        if ($id = $this->request->get('id')) {
            $role = $this->repository->find($id);
        }

        // process defined permissions
        $permissions = [];
        foreach ($this->getAdminPermissions() as $group => $commands) {
            foreach ($commands as $command) {
                $hasPermission = (! is_null($role)) ? $role->hasPermission($group, $command) : false;
                $permissions[$group][] = new Permission($group, $command, $hasPermission);
            }
        }

        // render view
        return view('Admin::permissions.manage', [
            'permissions' => new Collection($permissions),
            'roles' => $roles,
            'role'  => $role,
        ]);
    }

    /**
     * create model instance from old inputs
     *
     * @return App\Models\Role
     */
    protected function getRoleModelFromOldInput() : Role
    {
        $role = $this->repository->getModel()->newInstance();

        // populate model with old inputs
        foreach (old() as $key => $value) {
            $role->setAttribute($key, $value);
        }

        return $role;
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
